<div id="content">
<form method="post" action="" enctype="multipart/form-data">
<h2>Upload Home Gallery</h2>
<?php if (isset($a)) echo $a;?>
<input type="file" name="userfile[]" size="20" class="multi" multiple />
<br />
<input type="submit" class="submit" name="upload">
</form>
</div>