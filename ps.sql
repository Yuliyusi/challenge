DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getTable`(IN `conditions` TEXT)
    NO SQL
    COMMENT 'getalldata for database'
BEGIN
/*
 *@author jules@mediabox.bi
 *Le 17/11/2022 20h12
 *PS qui prend en parametre les condtions de filtrage pour le   
 *  datable du liste JSON
*/
   
SET @requetedebase:="SELECT `IDENTITE_ID`, `NOM`,s.SEXE_DESCR,e.DESCRIPTION,col.COLLINE_NAME FROM `identite` i JOIN sexe s ON i.`SEXE_ID`=s.SEXE_ID JOIN etat_civil e ON i.`ETAT_CIVIL_ID`=e.ETAT_CIVIL_ID JOIN collines col ON i.`COLLINE_ID`=col.COLLINE_ID WHERE 1";

SET @concatenedquery:=concat(@requetedebase,conditions);

PREPARE dynamic_statement FROM @concatenedquery;
EXECUTE dynamic_statement;
DEALLOCATE PREPARE dynamic_statement;

END$$
DELIMITER ;
---------------------------------------------------------------------
---------------------------------------------------------------------
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `recordsFiltered`(IN `conditionsfilter` VARCHAR(255))
    COMMENT 'recordsFiltered for datatable'
BEGIN
/*
*@author jules@mediabox.bi
*recordsFiltered for datatable
*/
SET @querydebase="SELECT COUNT(*) recordsFiltered FROM `identite` i JOIN sexe s ON i.`SEXE_ID` = s.SEXE_ID JOIN etat_civil e ON i.`ETAT_CIVIL_ID` = e.ETAT_CIVIL_ID JOIN collines col ON i.`COLLINE_ID` = col.COLLINE_ID WHERE 1";

SET @sqlcombined=concat(@querydebase,conditionsfilter);

PREPARE dynamic_statement FROM @sqlcombined;
EXECUTE dynamic_statement;
DEALLOCATE PREPARE dynamic_statement;
END$$
DELIMITER ;
--------------------------------------------------------------------------
--------------------------------------------------------------------------
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `recordsTotal`()
    COMMENT 'recordsTotal for datable'
BEGIN
/*
*@author jules@mediabox.bi
*recordsTotal for datatable
*/
    SELECT
        COUNT(*) AS recordsTotal
    FROM
        `identite` i
    JOIN sexe s ON
        i.`SEXE_ID` = s.SEXE_ID
    JOIN etat_civil e ON
        i.`ETAT_CIVIL_ID` = e.ETAT_CIVIL_ID
    JOIN collines col ON
        i.`COLLINE_ID` = col.COLLINE_ID
    WHERE
        1;
END$$
DELIMITER ;