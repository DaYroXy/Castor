<?php require APPROOT . '/views/inc/header.php'; ?>

<a href="<?php echo URLROOT ?>/posts" class="btn btn-dark mt-3"><i class="fa fa-backward"></i> Back</a>

<div class="card card-body mb-3 mt-3">
    <h4 class="card-title"><?php echo $data["post"]->title; ?></h4>
    
    <div class="bg-light p-2 mb-3">
        Written by <?php echo $data["post"]->name ?> on <?php echo $data["post"]->postCreated ?>
    </div>
    <p class="card-text"><?php echo $data["post"]->content ?></p>

    <?php if($data['post']->user_id === $_SESSION['user']['id']) : ?>
        <hr>
        <form action="<?php echo URLROOT ?>/posts/delete/<?php echo $data['post']->postId ?>" method="post">
            <a href="<?php echo URLROOT ?>/posts/edit/<?php echo $data['post']->postId ?>" class="btn btn-dark">Edit</a>
            <input type="submit" value="Delete" class="btn btn-danger">
        </form>
    <?php endif ?>
</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>