<?php

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$post = DopePost::byPostObject($this->post);

meta_form();
?>
Hello, are you <?php echo $post->getPost_type() ?> ?