<?php
class tasks
{
    protected int $task_id;
    protected int $project_id;
    protected int $column_id;
    protected string $name;
    protected ?string $description;
    protected ?string $due_date;
    protected int $created_by;
    protected string $created_at;
    protected string $updated_at;

    public function __construct(
        int $project_id,
        int $column_id,
        string $name,
        int $created_by,
        ?string $description = null,
        ?string $due_date = null,
        int $task_id = 0
    ) {
        $this->project_id = $project_id;
        $this->column_id = $column_id;
        $this->name = $name;
        $this->created_by = $created_by;
        $this->description = $description;
        $this->due_date = $due_date;
        $this->task_id = $task_id;
    }
}
?>