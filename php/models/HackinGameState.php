<?php
    class HackinGameState {
        public $email_id;
        public $current_level_no;
        public $current_mission_no;
        public $current_plot_no;
        public $current_count_of_attempts_made;
        public $current_score;
        public $is_user_alumni;
        public $plays_as_character;

        public function __construct($email_id, $current_level_no, $current_mission_no, $current_plot_no, $current_count_of_attempts_made, 
            $current_score, $is_user_alumni, $plays_as_character) {
            $this->email_id = $email_id;
            $this->current_level_no = $current_level_no;
            $this->current_mission_no = $current_mission_no;
            $this->current_plot_no = $current_plot_no;
            $this->current_count_of_attempts_made = $current_count_of_attempts_made;
            $this->current_score = $current_score;
            $this->is_user_alumni = $is_user_alumni;
            $this->plays_as_character = $plays_as_character;
        }
    }
    /*$hackinGameState = new HackinGameState("thirukkakarnan@gmail.com", 1, 1, 1, 0, 0, 1, "Veronica");
    echo json_encode($hackinGameState);*/
?>