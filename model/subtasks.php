<?php
class subtasks
{
    protected int $subtask_id;
    protected int $task_id;
    protected string $name;
    protected ?string $description;
    protected ?string $due_date;
    protected int $column_id;
    protected ?int $assigned_to;
    protected string $created_at;
    protected string $updated_at;

    public function __construct(
        int $task_id,
        string $name,
        int $column_id,
        ?string $description = null,
        ?string $due_date = null,
        ?int $assigned_to = null,
        int $subtask_id = 0
    ) {
        $this->task_id = $task_id;
        $this->name = $name;
        $this->column_id = $column_id;
        $this->description = $description;
        $this->due_date = $due_date;
        $this->assigned_to = $assigned_to;
        $this->subtask_id = $subtask_id;
    }
}
?>