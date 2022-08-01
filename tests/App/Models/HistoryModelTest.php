<?php

use App\Models\HistoryModel;
use PHPUnit\Framework\TestCase;

class HistoryModelTest extends TestCase
{
    /**
     * @dataProvider wrongArgumentsProvider
     */
    public function testInvalidArgument($key, $value): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new HistoryModel([
            $key => $value
        ]);
    }

    public function wrongArgumentsProvider(): array
    {
        return [
            ["action", "FORBIDDEN_ACTION"],
        ];
    }

    /**
     * @dataProvider validDataProvider
     *
     * @param mixed $id
     * @param string $actor_type
     * @param string|int $actor_id
     * @param string $action
     * @param string $subject_type
     * @param int $subject_id
     * @param array $oldValues
     * @param array $newValues
     * @param array $changes
     * @param string $created_at
     * @return void
     */
    public function testInitWithValidData($id, $actor_type, $actor_id, $action, $subject_type, $subject_id, $oldValues, $newValues, $changes, $created_at): void
    {
        $data = array(
            "id" => $id,
            "actor_type" => $actor_type,
            "actor_id" => $actor_id,
            "action" => $action,
            "subject_type" => $subject_type,
            "subject_id" => $subject_id,
            "oldValues" => $oldValues,
            "newValues" => $newValues,
            "changes" => $changes,
            "created_at" => $created_at,
        );
        $history = new HistoryModel($data);
        $this->assertSame($history->id, "NULL");
        $this->assertSame($history->actor_type, (string) $data["actor_type"]);
        $this->assertIsString($history->actor_type);
        $this->assertSame($history->actor_id, (string) $data["actor_id"]);
        $this->assertIsString($history->actor_id);
        $this->assertSame($history->action, $data["action"]);
        $this->assertSame($history->subject_type, $data["subject_type"]);
        $this->assertIsString($history->subject_type);
        $this->assertSame($history->subject_id, $data["subject_id"]);
        $this->assertIsInt($history->subject_id);
        $this->assertSame($history->oldValues, $data["oldValues"]);
        $this->assertSame($history->newValues, $data["newValues"]);
        $this->assertNotSame($history->changes, $data["changes"]);
        $this->assertSame($history->changes, [
            0 => [
                "date_entretien" => [
                    "old" => $data["oldValues"]["date_entretien"],
                    "new" => $data["newValues"]["date_entretien"],
                ]
            ]
        ]);
        $this->assertNull($history->created_at);
    }

    public function validDataProvider(): array
    {
        return array(
            [null, "USER", "fake@email.com", "'UPDATE'", "ENTRETIEN", 1, ["date_entretien" => null], ["date_entretien" => "01-01-2000 00:00"], [], null],
            [null, "USER", 1, "'DELETE'", "ENTRETIEN", 1, ["date_entretien" => null], ["date_entretien" => "01-01-2000 00:00"], [], null],
        );
    }
}
