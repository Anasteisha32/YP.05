<?php 
class projects
{
    protected int $project_id;
    protected string $name;
    protected ?string $description;
    protected bool $is_public;
    protected int $created_by;
    protected string $created_at;
    protected string $updated_at;

    public function __construct(
        string $name,
        int $created_by,
        ?string $description = null,
        bool $is_public = false,
        int $project_id = 0
    ) {
        $this->name = $name;
        $this->created_by = $created_by;
        $this->description = $description;
        $this->is_public = $is_public;
        $this->project_id = $project_id;
    }
}
?>