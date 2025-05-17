<?php
class user
{
    protected int $user_id;
    protected string $email;
    protected string $password;
    protected string $first_name;
    protected string $last_name;
    protected ?string $middle_name;
    protected ?string $biography;
    protected string $created_at;
    protected string $updated_at;

    public function __construct(
        string $email,
        string $password,
        string $first_name,
        string $last_name,
        ?string $middle_name = null,
        ?string $biography = null,
        int $user_id = 0
    ) 
    {
        $this->email = $email;
        $this->password = $password;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->middle_name = $middle_name;
        $this->biography = $biography;
        $this->user_id = $user_id;
    }
}
?>