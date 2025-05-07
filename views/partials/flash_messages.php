<?php
use Core\Session;

if (Session::getSuccessMessage()): ?>
    <div class="alert alert-success"><?= Session::getSuccessMessage() ?></div>
<?php endif; ?>

<?php if (Session::getErrorMessage()): ?>
    <div class="alert alert-danger"><?= Session::getErrorMessage() ?></div>
<?php endif; ?>

<?php if (Session::getInfoMessage()): ?>
    <div class="alert alert-info"><?= Session::getInfoMessage() ?></div>
<?php endif; ?>
