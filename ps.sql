DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteData`(IN `tableused` VARCHAR(30), IN `conditions` VARCHAR(255))
BEGIN
/*DELETE FROM `hobbies` WHERE `hobbies`.`ID_HOBBY` = 6*/
   SET @sqlcombined=concat('DELETE FROM ',tableused,' WHERE ',conditions);

    PREPARE dynamic_statement FROM @sqlcombined;
    EXECUTE dynamic_statement;
    DEALLOCATE PREPARE dynamic_statement;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getProvComZonFromColline`(IN `id_col` INT)
BEGIN
SELECT z.`ZONE_ID`,co.COMMUNE_ID,p.PROVINCE_ID FROM `collines` c JOIN zones z ON c.`ZONE_ID`=z.ZONE_ID JOIN communes co ON z.COMMUNE_ID=co.COMMUNE_ID JOIN provinces p ON co.PROVINCE_ID=p.PROVINCE_ID WHERE c.`COLLINE_ID`=id_col;

END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getRequete`(IN `columnselect` TINYTEXT, IN `tableused` VARCHAR(50), IN `whereclause` TINYTEXT, IN `order_by` VARCHAR(200))
BEGIN
/*@author jules@mediabox.bi 
*le 1-12-2022 
*PS qui retourne une liste ,il prend en parametre : 
* -les colones selectionnes 
* -la table 
* -les conditions de la clause WHERE 
* -l'ordre
* Ex:-SELECT `PROVINCE_ID`, `PROVINCE_NAME` FROM `provinces` WHERE 1  ORDER BY `PROVINCE_NAME` ASC
*/ 
   
   SET @sqlcombined=concat('SELECT ',columnselect,' FROM ',tableused,' WHERE ',whereclause,' ORDER BY ',order_by);

    PREPARE dynamic_statement FROM @sqlcombined;
    EXECUTE dynamic_statement;
    DEALLOCATE PREPARE dynamic_statement;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertIntoTable`(IN `tableused` VARCHAR(50), IN `datatoinsert` TINYTEXT)
BEGIN
 /*INSERT INTO `hobbies` VALUES (null,"dealer")*/
   SET @sqlcombined=concat('INSERT INTO ',tableused,' VALUES (null, ',datatoinsert,' )');

    PREPARE dynamic_statement FROM @sqlcombined;
    EXECUTE dynamic_statement;
    DEALLOCATE PREPARE dynamic_statement;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertLastIdIntoTable`(IN `tableused` VARCHAR(50), IN `datatoinsert` TINYTEXT)
    NO SQL
    COMMENT 'insert and get last insert id'
BEGIN
 /*INSERT INTO `hobbies` VALUES (null,"dealer")*/
   SET @sqlcombined=concat('INSERT INTO ',tableused,' VALUES (null, ',datatoinsert,' )');

    PREPARE dynamic_statement FROM @sqlcombined;
    EXECUTE dynamic_statement;
    DEALLOCATE PREPARE dynamic_statement;
    SELECT LAST_INSERT_ID() AS id;
END$$
DELIMITER ;

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

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateData`(IN `tableused` VARCHAR(50), IN `datatomodifie` TINYTEXT, IN `conditions` VARCHAR(255))
BEGIN
/*UPDATE `hobbies` SET `ID_HOBBY`='',`HOBBY`='' WHERE 0;*/

   SET @sqlcombined=concat('UPDATE ',tableused,' SET ',datatomodifie,' WHERE ',conditions);

    PREPARE dynamic_statement FROM @sqlcombined;
    EXECUTE dynamic_statement;
    DEALLOCATE PREPARE dynamic_statement;
END$$
DELIMITER ;

