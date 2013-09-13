<div class="sleeve_main">
    <div id="main">
        <?php echo $message ?>
        <div style="float:left">
            <h2>Daftar</h2>
            <?php
            echo form_open('authenticate/register');
            $data = array(
                array('email', '&nbsp;:&nbsp;' . form_input('email', set_value('email'))),
                array('password', '&nbsp;:&nbsp;' . form_password('password')),
                array('ulangi', '&nbsp;:&nbsp;' . form_password('again')),
                array('', form_submit('register', 'daftar'))
            );
            echo $this->table->generate($data);
            echo form_close();
            ?>
        </div>
        <div style="float:right;margin-right:50px">
            <h2>Login</h2>
            <?php
            echo form_open('authenticate/login');
            $data = array(
                array('email', '&nbsp;:&nbsp;' . form_input('email', set_value('email'))),
                array('password', '&nbsp;:&nbsp;' . form_password('password')),
                array('', form_submit('login', 'login'))
            );
            echo $this->table->generate($data);
            echo form_close();
            ?>
        </div>
        <div style="clear:both; height: 0"></div>
        <?php
        if(isset($message_history)){
            echo $message_history;
            $this->table->set_template(array ( 'table_open'  => '<table border="0" cellpadding="2" cellspacing="3">' ));
            $this->table->set_heading('<strong>Waktu</strong>', '<strong>Aksi</strong>', '<strong>Nilai</strong>', '<strong>Status</strong>');
            echo $this->table->generate($list_history->result_array());
        }
        ?>
    </div> <!-- main -->
</div> <!-- sleeve -->