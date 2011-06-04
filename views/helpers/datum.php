<?php
class DatumHelper extends Helper
{
        /* Diese Funktion wandelt SQL Datumsangaben im Datetimeformat
         * in das deutsche Datumsformat um. Folgende Optionen können
         * angegeben werden:
         * 0 oder keine Angabe: Nur das Datum wird erstellt.
         * 1: Es werden auch Stunden und Minuten ausgegeben.
         * 2: Es werden Stunden, Minuten und Sekunden ausgegeben.
         */
       
        function date_de($datum,$option = NULL) {
                //Datum umwandeln
                $ausgabe = date('d.m.Y', strtotime($datum));
                //Prüfen ob Optionen angebeben
                if ($option == 1) {
                        //Anhängen der Stunden und Minuten
                        $ausgabe .= date(' H:i', strtotime($datum))." Uhr";
                } elseif ($option == 2) {
                        //Anhängen der Stunden, Minuten und Sekunden
                        $ausgabe .= date(' H:i:s', strtotime($datum))." Uhr";
                }
                return $this->output($ausgabe);
        }
}
?>