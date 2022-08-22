<?php 
echo $output; 
?>

<script>
    $(document).ready(function(){
    $('#field-tgl_lahir').datepicker(
        {
            changeMonth: false,
            changeYear: false,
            yearRange: '1950:2011'
        }
    );
});
</script>