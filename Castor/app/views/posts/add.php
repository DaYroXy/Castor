<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <a href="<?php echo URLROOT ?>/posts" class="btn btn-dark mt-3"><i class="fa fa-backward"></i> Back</a>
    <div class="card card-body bg-light mt-3">
        <h3>Add post</h3>
        <p>Please fill out this form to post </p>
        <form action="<?php echo URLROOT ?>/posts/add" method="post">
            <div class="form-group mb-3">
                <label for="title">Title: <sup>*</sup></label>
                <input type="text" name="title" class="form-control form-control-md 
                    <?php echo (!empty($data["title_error"])) ? 'is-invalid' :'' ?>"
                    value="<?php echo $data['title']; ?>">
                <span class="invalid-feedback"><?php echo $data['title_error'] ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="content">Content: <sup>*</sup></label>
                <textarea type="text" name="content" class="form-control form-control-md 
                    <?php echo (!empty($data["content_error"])) ? 'is-invalid' :'' ?>"
                    ><?php echo $data['content']; ?></textarea>
                <span class="invalid-feedback"><?php echo $data['content_error'] ?></span>
            </div>
            <input type="submit" class="btn btn-success" value="Submit">
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>