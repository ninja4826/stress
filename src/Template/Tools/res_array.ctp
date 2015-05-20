<div id="spark-login" />

<?= $this->Html->script('spark.min')?>
<script>
    sparkLogin(function(data) {
        console.log(data);
    });
</script>