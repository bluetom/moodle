<?php
// This file keeps track of upgrades to
// the choice module
//
// Sometimes, changes between versions involve
// alterations to database structures and other
// major things that may break installations.
//
// The upgrade function in this file will attempt
// to perform all the necessary actions to upgrade
// your older installation to the current version.
//
// If there's something it cannot do itself, it
// will tell you what you need to do.
//
// The commands in here will all be database-neutral,
// using the methods of database_manager class
//
// Please do not forget to use upgrade_set_timeout()
// before any action that may take longer time to finish.

defined('MOODLE_INTERNAL') || die();

function xmldb_choice_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    // Automatically generated Moodle v3.9.0 release upgrade line.
    // Put any upgrade step following this.

    if ($oldversion < 2020061600) {
        // Define field showavailable to be added to choice.
        $table = new xmldb_table('choice');
        $field = new xmldb_field('showavailable', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0', 'completionsubmit');

        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Choice savepoint reached.
        upgrade_mod_savepoint(true, 2020061600, 'choice');
    }
    // Automatically generated Moodle v4.0.0 release upgrade line.
    // Put any upgrade step following this.

    // Automatically generated Moodle v4.1.0 release upgrade line.
    // Put any upgrade step following this.

    if ($oldversion < 2022112801) {
        // Define field fraction to be added to choice_options.
        $table = new xmldb_table('choice_options');
        $field = new xmldb_field('fraction', XMLDB_TYPE_NUMBER, '10, 5', null, null, null, null, 'maxanswers');

        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field grade to be added to choice.
        $table = new xmldb_table('choice');
        $field = new xmldb_field('grade', XMLDB_TYPE_NUMBER, '10,5', null, null, null, null, 'showavailable');

        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define table choice_grades to be created.
        $table = new xmldb_table('choice_grades');

        // Conditionally launch create table for choice_grades.
        if (!$dbman->table_exists($table)) {
            // Adding fields to table choice_grades.
            $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
            $table->add_field('choiceid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('grade', XMLDB_TYPE_NUMBER, '10, 5', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

            $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
            $dbman->create_table($table);
        }

        // Choice savepoint reached.
        upgrade_mod_savepoint(true, 2022112801, 'choice');
    }

    return true;
}
