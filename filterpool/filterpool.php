<?php$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";   //*************************************************************************// script pour la filtration de la piscine//*************************************************************************function sdk_set_interval ($debut, $fin) {  return ['debut' => $debut, 'fin' => $fin];}function sdk_mktime_interval($heures_debut, $minutes_debut, $ajout_heures_fin, $ajout_minutes_fin) {  $horaire_debut = mktime($heures_debut, $minutes_debut);  $horaire_fin = mktime($heures_debut + $ajout_heures_fin, $minutes_debut + $ajout_minutes_fin);  return sdk_set_interval($horaire_debut, $horaire_fin);}function sdk_calcul_horaires_avec_formule($To, $he_debut, $mi_debut, $formule) {  list($t0, $h0) = sscanf($formule, '%f*T+%d');  $f_he_formule = $t0 * $To + $h0;  $he_formule = ceil($f_he_formule);  $mi_formule = ceil(($f_he_formule - $he_formule) / 60);  return sdk_mktime_interval($he_debut, $mi_debut, $he_formule, $mi_formule);}function sdk_determiner_mode($To, $Ta) {  // DÉTERMINATION DU MODE  if ($To <= 4 && $Ta < -0.5) return 10;                // froid extrème  elseif ($To > 4 && $To <= 15 && $Ta >= 0) return 11;   // hivernage  elseif ($To > 15 && $To <= 20 && $Ta >= 0) return 12;  // tempéré  elseif ($To > 20 && $To <= 27 && $Ta >= 0) return 13;  // été  elseif ($To > 27 && $Ta >= 28) return 14;             // canicule  else return 12;                                       // no mode (tempéré par défaut)}function sdk_init($To, $Ta, $D, $Formules) {  $demain_minuit = mktime(0, 0, 0) + 24 * 60 * 60;  $mode = sdk_determiner_mode($To, $Ta);  // DÉTERMINATION DES HORAIRES DE DÉBUT ET DE FIN DE CYCLE  list($he, $mi) = sscanf($D, '%d:%d');  $horaires = [];  switch ($mode) {    case 10: // froid extrème      do {        $heure_debut = mktime($he+=2, $mi);        $horaires[] = sdk_set_interval($heure_debut, mktime($he, $mi + 10));      } while($heure_debut < $demain_minuit);    break;    case 11: // hivernage      $horaires[] = sdk_calcul_horaires_avec_formule($To, $he, $mi, $Formules['ModeFroid']);    break;    case 12: // tempéré      $horaires[] = sdk_calcul_horaires_avec_formule($To, $he, $mi, $Formules['ModeTempere']);    break;    case 13: // été      $horaires[] = sdk_calcul_horaires_avec_formule($To, $he, $mi, $Formules['ModeChaud']);    break;    case 14: // canicule      $horaires[] = sdk_calcul_horaires_avec_formule($To, $he, $mi, $Formules['ModeCanicule']);    break;    default:  }  saveVariable('DemainMinuit', $demain_minuit);  saveVariable('Mode', $mode);  saveVariable('Horaires', $horaires);}function sdk_demarrer_pompe($horaires, $maintenant) {  foreach ($horaires as $interval) {    if ($interval['debut'] <= $maintenant && $interval['fin'] >= $maintenant) {      return 100;    }  }  return 0;}// RÉCUPÉRATION DES VARIABLES DE L'ACTIONNEUR$MoteurPiscine = getValue('moteur_piscine');$To = getValue('sonde_eau');$Ta = getValue('sonde_air');$D = getValue('debut');// Formules pour les Modes$Formules = [];$Formules['ModeFroid'] = getValue('mode_froid', '0*T+0');$Formules['ModeTempere'] = getValue('mode_tempere', '0.2*T+0');$Formules['ModeChaud'] = getValue('mode_chaud', '0.25*T+0');$Formules['ModeCanicule'] = '0.4*T+0';// Vérification des horaire$demain_minuit = loadVariable('DemainMinuit');$maintenant = time();// On initialise les horaires de fonctionnementif (!isset($demain_minuit) || $maintenant >= $demain_minuit) {  sdk_init($To, $Ta, $D, $Formules);}// CHARGEMENT DES VARIABLES$mode = loadVariable('Mode');$horaires = loadVariable('Horaires');$demain_minuit = loadVariable('DemainMinuit');setValue($MoteurPiscine, sdk_demarrer_pompe($horaires, $maintenant));$xml='<FILTERPOOL>';$xml .= '<Mode>'.loadVariable('Mode').'</Mode>';$xml .= '<Horaires>'.loadVariable('Horaires').'</Horaires>';$xml .= '<DemainMinuit>'.date('d/m/Y H:i', loadVariable('DemainMinuit')).'</DemainMinuit>';$xml .= '</FILTERPOOL>';sdk_header('text/xml');echo htmlentities($xml);?>