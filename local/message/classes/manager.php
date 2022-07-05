<?php
// This file is part of Moodle Course Rollover Plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * @package     local_message
 * @author      Kristian
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_message;

use dml_exception;
use stdClass;

/**
 * pobabaly  main class
 *
 *
 */
class manager {

    /** Insert the data into our database table.
     * @param string $message_text
     * @param string $message_type
     * @return bool true if successful
     */
    public function create_message(string $message_text, string $message_type): bool
    {
        global $DB;
        /**
         * The stdClass is the empty class in PHP which is used to cast other types to object.
         * It is similar to Java or Python object. The stdClass is not the base class of the objects.
         * If an object is converted to object, it is not modified
         *
         * std class wirtualn klasa wbud w php - uzywanie przy konwersji np tablicy do obiektu
         */
        $record_to_insert = new stdClass();
        $record_to_insert->messagetext = $message_text;//add new attr to class dynamically
        $record_to_insert->messagetype = $message_type;
        try {
            return $DB->insert_record('local_message', $record_to_insert, false);//inser record to DB
        } catch (dml_exception $e) {//dml exception moodle exeption class
            return false;
        }
    }

    /** Gets all messages that have not been read by this user
     * @param int $userid the user that we are getting messages for
     * @return array of messages
     */
    public function get_messages(int $userid): array
    {
        /**
         * sleekcja ilku kolumn z dwoch tabel lmr i lm
         *  wyslelecjonuj te  kolumny w kotrych id jest zbiezne z tabela lm
         *
         */
        global $DB;
        $sql = "SELECT lm.id, lm.messagetext, lm.messagetype 
            FROM {local_message} lm 
            LEFT OUTER JOIN {local_message_read} lmr ON lm.id = lmr.messageid AND lmr.userid = :userid 
            WHERE lmr.userid IS NULL";
        $params = [
            'userid' => $userid,
        ];
        try {
            return $DB->get_records_sql($sql, $params);//pobranie rekordow zgodnych z instr sql
        } catch (dml_exception $e) {
            // Log error here.
            return [];
        }
    }

    /** Gets all messages
     * @return array of messages
     */
    public function get_all_messages(): array {
        global $DB;
        return $DB->get_records('local_message');
    }

    /** Mark that a message was read by this user.
     * @param int $message_id the message to mark as read
     * @param int $userid the user that we are marking message read
     * @return bool true if successful
     *
     * njprwd wstawianie do tabeli lmr tych msg oznacoznych jako przeczytane
     */
    public function mark_message_read(int $message_id, int $userid): bool
    {
        global $DB;
        $read_record = new stdClass();
        $read_record->messageid = $message_id;
        $read_record->userid = $userid;
        $read_record->timeread = time();//stempel czasowy
        try {
            return $DB->insert_record('local_message_read', $read_record, false);
        } catch (dml_exception $e) {
            return false;
        }
    }

    /** Get a single message from its id.
     * @param int $messageid the message we're trying to get.
     * @return object|false message data or false if not found.
     */
    public function get_message(int $messageid)
    {
        global $DB;
        return $DB->get_record('local_message', ['id' => $messageid]);
    }

    /** Update details for a single message.
     * @param int $messageid the message we're trying to get.
     * @param string $message_text the new text for the message.
     * @param string $message_type the new type for the message.
     * @return bool message data or false if not found.
     */
    public function update_message(int $messageid, string $message_text, string $message_type): bool
    {
        global $DB;
        $object = new stdClass();
        $object->id = $messageid;
        $object->messagetext = $message_text;
        $object->messagetype = $message_type;
        return $DB->update_record('local_message', $object);
    }

    /** Update the type for an array of messages.
     * @return bool message data or false if not found.
     */
    public function update_messages(array $messageids, $type): bool
    {
        global $DB;
        //list - fast create pair of var and values using array
        /**
         * get_in_or_equal - built in moodle - tworzy kwerendy do DB typu:
         * SELECT * FROM Customers
        WHERE Country IN ('Germany', 'France', 'UK');
         *
         * tutaj: zwroci tablice wartosci tych kolumn w ktorych sa meeseids
         */
        list($ids, $params) = $DB->get_in_or_equal($messageids);//(array)
        //set filedselect njprwd tworzy nowe pola o nazwie mesage typie wsedzie tam gdzie dopasowane jest zapytanie sql
        return $DB->set_field_select('local_message', 'messagetype', $type, "id $ids", $params);
    }

    /** Delete a message and all the read history.
     * @param $messageid
     * @return bool
     * @throws \dml_transaction_exception
     * @throws dml_exception
     */
    public function delete_message($messageid)
    {
        global $DB;
        /**
         * W bazach danych, które to obsługują, przełącz się w tryb transakcyjny i rozpocznij transakcję
         * https://www.youtube.com/watch?v=Mnwow8ZoPrM
         * https://docs.moodle.org/dev/DB_layer_2.0_delegated_transactions
         *
         * Transakce to zbior operacje typu CRUD - insert, update delete
         * sciesle powiazenie z :
         *
         * Data Manipulation Language lub DML to podzbiór operacji służący do wstawiania, usuwania i aktualizowania danych w bazie danych.
         * DML jest często podjęzykiem bardziej rozbudowanego języka, takiego jak SQL; DML zawiera niektóre operatory w języku
         *
         *
         */
        $transaction = $DB->start_delegated_transaction();//rozpocznij oddelelgowane rttansakcje??
        $deletedMessage = $DB->delete_records('local_message', ['id' => $messageid]);//delete recored from db with selected ids
        $deletedRead = $DB->delete_records('local_message_read', ['messageid' => $messageid]);
        if ($deletedMessage && $deletedRead) {//jesli rekoredy poprwanie ususniete
            $DB->commit_delegated_transaction($transaction);//zatwerdzenie transkacji w db njpwrd uzycie sql commit w instrukcji wykonania
        }
        return true;
    }

    /** Delete all messages by id.
     * @param $messageids
     * @return bool
     */
    public function delete_messages($messageids)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        //get_in_or_equal -
        list($ids, $params) = $DB->get_in_or_equal($messageids);
        $deletedMessages = $DB->delete_records_select('local_message', "id $ids", $params);//usun wybrane rekordy
        $deletedReads = $DB->delete_records_select('local_message_read', "messageid $ids", $params);
        if ($deletedMessages && $deletedReads) {
            $DB->commit_delegated_transaction($transaction);//zatwerdzenie transakcji
        }
        return true;
    }
}
