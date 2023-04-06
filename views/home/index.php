<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>
<div class="content">
    <h1>This is home page of Fountain test</h1><br />
    <p>You will be asked to answer the following questions when submitting a proposal:<br /><br />
    <ol>
        <li>Please create the first 2 tables of the attached brief by using Object-oriented PHP. DO NOT WRITE SQL CODE.
            Write the php OOP class that will enable to get/set every property of the table. Applications without this
            question answered will not be considererd</li>
        <li>Do you have suggestions to make this project run successfully?</li>
    </ol>
    </p>
    <hr>
    <h2>List tables</h2>
    <?php $usertables = [];  ?>
</div>
<?php include_once 'views/layout/'.$this->layout.'footer.php'; ?>