<?PHP
ECHO "<pre>

TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `nexthor_empresa`.`documento_interno_BEFORE_INSERT` BEFORE INSERT ON `documento_interno` FOR EACH ROW\nBEGIN\n	declare var_serie VARCHAR(45);\n	declare var_correlativo int;\n	declare var_fecha date;\n	\n    select ifnull(serie,'SIN SERIE'), correlativo, fecha into var_serie, var_correlativo, var_fecha\n	from serie_documento where idserie_documento = new.idserie_documento;\n    \n    if new.fecha < var_fecha then\n		set new.fecha = var_fecha;\n    end if;\n    update serie_documento set correlativo = correlativo + 1, fecha = new.fecha where idserie_documento = new.idserie_documento;\n	\n	set new.serie = var_serie;\n	set new.correlativo = var_correlativo;\n	set new.fecha_insercion = now();\nEND'
sql_modes=1073741824
definers='root@localhost'
client_cs_names='utf8'
connection_cl_names='utf8_general_ci'
db_cl_names='utf8_spanish_ci'

</pre>"
?>