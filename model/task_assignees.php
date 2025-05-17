<?php 
class task_assignees
{
    protected int $task_assignee_id;
    protected int $task_id;
    protected int $user_id;
    protected string $assigned_at;

    public function __construct(
        int $task_id,
        int $user_id,
        int $task_assignee_id = 0
    ) {
        $this->task_id = $task_id;
        $this->user_id = $user_id;
        $this->task_assignee_id = $task_assignee_id;
    }
}
?>