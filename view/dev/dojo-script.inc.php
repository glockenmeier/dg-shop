<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 * 
 * 
 */
?>

<script data-dojo-config="async: <?php echo $this->async ?>,
        isDebug: 0,
        packages: [ {
            name: '<?php echo $this->package ?>',
            location: location.pathname.replace(/\/[^/]+$/, '') + '<?php echo $this->location ?>'
        } ]"
    src="<?php echo $this->src ?>"></script>
