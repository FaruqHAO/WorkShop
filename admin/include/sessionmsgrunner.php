<script >
    $(function () {
        if (<?php echo $msgshow ?> === 1) {
//        console.log(<?php // echo $msg   ?>);    
//        console.log("<?php echo $msg[0] ?>", "<?php echo $msg[1] ?>", "<?php echo $msg[2] ?>");
            swal({
                title: "<?php echo $msg[0] ?> ",
                text: "<?php echo $msg[1] ?>",
//                html: "<strong><?php // echo $msg[1]   ?></strong>",
                type: "<?php echo $msg[2] ?>",
                timer: 3500,
                showConfirmButton: false,
                position: "top-start"
            });
        <?php
        $msgshow = 0;
        unset($msg);
        ?>
                } else {
        <?php $msgshow = 0; ?>
                }
    });
</script>