<?php 
class project_members
{
    protected int $project_member_id;
    protected int $project_id;
    protected int $user_id;
    protected string $role;
    protected string $joined_at;

    public function __construct(
        int $project_id,
        int $user_id,
        string $role,
        int $project_member_id = 0
    ) {
        $this->project_id = $project_id;
        $this->user_id = $user_id;
        $this->role = $role;
        $this->project_member_id = $project_member_id;
    }
}
?>