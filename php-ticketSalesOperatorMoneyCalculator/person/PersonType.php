<?php 
class PersonType
{
    private const PERSONTYPES = [
        "adult",
        "child",
        "senior"
    ];

    /**
     * タイプを取得
     * @return array タイプ
     */
    public function getPersonTypes(): array
    {
        return self::PERSONTYPES;
    }
}

?>