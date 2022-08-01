<?php

use App\Models\EntretienModel;
use PHPUnit\Framework\TestCase;

class InterviewModelTest extends TestCase
{
    public function testInitialization(): void
    {
        $data = [
            "idENTR" => 1,
            "AU_id" => 2,
            "NIV_id" => 3,
            "DO_id" => 4,
            "REC_id" => 5,
            "GP_id" => 6,
            "AB_id" => 7,
            "SB_id" => 8,
            "MB_id" => 9,
            "nom" => "Fake name",
            "prenom" => "Fake firstName",
            "sexe" => "0",
            "contact" => "+261 23 456 78",
            "date_entretien" => "today + 1.day",
        ];
        $meeting = new EntretienModel($data);
        $this->assertSame($meeting->idENTR, $data["idENTR"]);
        $this->assertSame($meeting->AU_id, $data["AU_id"]);
        $this->assertSame($meeting->NIV_id, $data["NIV_id"]);
        $this->assertSame($meeting->DO_id, $data["DO_id"]);
        $this->assertSame($meeting->REC_id, $data["REC_id"]);
        $this->assertSame($meeting->GP_id, $data["GP_id"]);
        $this->assertSame($meeting->AB_id, $data["AB_id"]);
        $this->assertSame($meeting->SB_id, $data["SB_id"]);
        $this->assertSame($meeting->MB_id, $data["MB_id"]);
        $this->assertSame($meeting->nom, $data["nom"]);
        $this->assertSame($meeting->prenom, $data["prenom"]);
        $this->assertSame($meeting->sexe, $data["sexe"]);
        $this->assertSame($meeting->contact, $data["contact"]);
        $this->assertSame($meeting->date_entretien, $data["date_entretien"]);
    }
}
