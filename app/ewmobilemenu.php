<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(3, "mmi_medicamento", $Language->MenuPhrase("3", "MenuText"), "medicamentolist.php?cmd=resetall", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(6, "mmci_Cate1logos", $Language->MenuPhrase("6", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(5, "mmi_registro_sanitario", $Language->MenuPhrase("5", "MenuText"), "registro_sanitariolist.php?cmd=resetall", 6, "", TRUE, FALSE);
$RootMenu->AddMenuItem(4, "mmi_pais", $Language->MenuPhrase("4", "MenuText"), "paislist.php", 6, "", TRUE, FALSE);
$RootMenu->AddMenuItem(2, "mmi_marca", $Language->MenuPhrase("2", "MenuText"), "marcalist.php?cmd=resetall", 6, "", TRUE, FALSE);
$RootMenu->AddMenuItem(1, "mmi_laboratorio", $Language->MenuPhrase("1", "MenuText"), "laboratoriolist.php?cmd=resetall", 6, "", TRUE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
