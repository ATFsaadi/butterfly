USE `bfly`;

DROP TRIGGER IF EXISTS `trg_reservation_voyage_decrement_places`;
DROP TRIGGER IF EXISTS `trg_voyage_complet`;

DELIMITER $$

CREATE TRIGGER `trg_reservation_voyage_decrement_places`
BEFORE INSERT ON `reservations_voyages`
FOR EACH ROW
BEGIN
  UPDATE `voyages_organises`
  SET `nb_places_restantes` = `nb_places_restantes` - NEW.`nb_personnes`
  WHERE `id_voyage` = NEW.`id_voyage`
    AND `statut` = 'actif'
    AND `nb_places_restantes` >= NEW.`nb_personnes`;

  IF ROW_COUNT() = 0 THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Places insuffisantes pour ce voyage';
  END IF;
END$$

CREATE TRIGGER `trg_voyage_complet`
BEFORE UPDATE ON `voyages_organises`
FOR EACH ROW
BEGIN
  IF NEW.`nb_places_restantes` = 0 AND NEW.`statut` = 'actif' THEN
    SET NEW.`statut` = 'complet';
  END IF;
END$$

DELIMITER ;
