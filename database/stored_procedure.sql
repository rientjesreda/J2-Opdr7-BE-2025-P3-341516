USE be_opdracht_7;

DROP PROCEDURE IF EXISTS spUpdateVehicleAndAssignment;

DELIMITER $$

CREATE PROCEDURE spUpdateVehicleAndAssignment(
    IN pVehicleId INT,
    IN pKenteken VARCHAR(10),
    IN pType VARCHAR(50),
    IN pBrandstof VARCHAR(20),
    IN pInstructorId INT,
    IN pOpmerking VARCHAR(250)
)
BEGIN
    DECLARE vCurrentAssignmentId INT DEFAULT NULL;
    DECLARE vCurrentInstructorId INT DEFAULT NULL;

    SELECT Id, InstructeurId
      INTO vCurrentAssignmentId, vCurrentInstructorId
    FROM VoertuigInstructeur
    WHERE VoertuigId = pVehicleId
      AND IsActief = 1
    LIMIT 1;

    UPDATE Voertuig
    SET Kenteken = pKenteken,
        Type = pType,
        Brandstof = pBrandstof,
        Opmerking = pOpmerking,
        DatumGewijzigd = CURRENT_TIMESTAMP(6)
    WHERE Id = pVehicleId;

    IF vCurrentAssignmentId IS NULL THEN
        INSERT INTO VoertuigInstructeur (VoertuigId, InstructeurId, DatumToekenning, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
        VALUES (pVehicleId, pInstructorId, CURDATE(), b'1', pOpmerking, CURRENT_TIMESTAMP(6), CURRENT_TIMESTAMP(6));
    ELSEIF vCurrentInstructorId <> pInstructorId THEN
        UPDATE VoertuigInstructeur
        SET IsActief = b'0',
            Opmerking = CONCAT('Vorige toewijzing gesloten. ', COALESCE(pOpmerking, '')),
            DatumGewijzigd = CURRENT_TIMESTAMP(6)
        WHERE Id = vCurrentAssignmentId;

        INSERT INTO VoertuigInstructeur (VoertuigId, InstructeurId, DatumToekenning, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
        VALUES (pVehicleId, pInstructorId, CURDATE(), b'1', pOpmerking, CURRENT_TIMESTAMP(6), CURRENT_TIMESTAMP(6));
    ELSE
        UPDATE VoertuigInstructeur
        SET Opmerking = pOpmerking,
            DatumGewijzigd = CURRENT_TIMESTAMP(6)
        WHERE Id = vCurrentAssignmentId;
    END IF;
END $$

DELIMITER ;
