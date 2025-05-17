<?php 
class kanban_columns
{
    protected int $column_id;
    protected int $project_id;
    protected string $name;
    protected int $position;
    protected string $created_at;
    protected string $updated_at;

    public function __construct(
        int $project_id,
        string $name,
        int $position,
        int $column_id = 0
    ) {
        $this->project_id = $project_id;
        $this->name = $name;
        $this->position = $position;
        $this->column_id = $column_id;
    }
}
?>