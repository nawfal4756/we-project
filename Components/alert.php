<div class='my-4'>
    <div class='alert alert-dismissible' id='alertBox' role='alert' style="display: none;">
        <div id='alertMessage'></div>
        <button type='button' class='btn-close' id='alertClose'></button>
    </div>
</div>


<script>
    let alertBox = $('#alertBox')
    let alertMessage = $('#alertMessage')
    let alertCloseBtn = $('#alertClose')

    function showAlert(message, type) {
        alertMessage.html(message)
        alertBox.addClass('alert-' + type)
        alertBox.slideDown()
        setTimeout(function() {
            alertBox.slideUp()
            alertBox.removeClass('alert-' + type)
        }, 5000)
    }

    alertCloseBtn.click(function() {
        alertBox.slideUp()
    })
</script>