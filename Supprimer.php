<?php
    session_start ();
    $pIntitule = $_GET['intitule'];

    $fichier = "ListeQCM/" . $pIntitule . ".xml";
    unlink($fichier);

    $nomFichier = "LesQCM.xml";
    $Resultats = new SimpleXMLElement($nomFichier, NULL, TRUE);

    $donneeXML = "<qcm>";

    foreach ($Resultats->unTheme as $unTheme) {
        foreach($unTheme->attributes() as $a => $b) {
            $libelle = $b;
        }
        
        $donneeXML = $donneeXML . "<unTheme libelle='" . $libelle . "'>";

        foreach($unTheme->unQCM as $unQCM) {
            if($unQCM->intitule != $pIntitule) {
                $donneeXML = $donneeXML . "<unQCM><intitule>" . $unQCM->intitule . "</intitule></unQCM>";
            }
        }
        $donneeXML = $donneeXML . "</unTheme>";
    }

    $donneeXML = $donneeXML . "</qcm>";

    $fichier = fopen($nomFichier, 'r+');
    ftruncate($fichier,0);
    fseek($fichier, 0);
    fputs($fichier, $donneeXML);
    fclose($fichier);


    $nomFichier = "Resultats.xml";
    $Resultats = new SimpleXMLElement($nomFichier, NULL, TRUE);

    $donneeXML = "<resultats>";

    foreach ($Resultats->unQCM as $unQCM) {
        foreach($unQCM->attributes() as $a => $b) {
            $intitule = $b;
        }
        if($intitule != $pIntitule) {
            $donneeXML = $donneeXML . "<unQCM intitule='" . $intitule . "'>";

            foreach($unQCM->unEleve as $unEleve) {
                foreach($unEleve->attributes() as $c => $d) {
                    $id = $d;
                }
                    $donneeXML = $donneeXML . "<unEleve id='" . $id . "'>" . $unEleve ."</unEleve>";
            }
            $donneeXML = $donneeXML . "</unQCM>";
        }
    }

    $donneeXML = $donneeXML . "</resultats>";

    $fichier = fopen($nomFichier, 'r+');
    ftruncate($fichier,0);
    fseek($fichier, 0);
    fputs($fichier, $donneeXML);
    fclose($fichier);
?>