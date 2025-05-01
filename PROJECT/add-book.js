document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('bookForm');
    const submitBtn = document.getElementById('submitBtn');
    const fileStatus = document.getElementById('fileStatus');
    const successMessage = document.getElementById('successMessage');

    // پشکنینی فۆرم
    function checkForm() {
        const inputs = form.querySelectorAll('input[required]');
        let isValid = true;
        
        inputs.forEach(input => {
            if (!input.value.trim()) isValid = false;
        });
        
        const pdf = document.getElementById('pdf').files[0];
        if (!pdf || pdf.type !== 'application/pdf') isValid = false;
        
        submitBtn.disabled = !isValid;
    }

    // گوێگرتن لە گۆڕانکارییەکان
    form.addEventListener('input', checkForm);
    document.getElementById('pdf').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            if (file.type === 'application/pdf') {
                fileStatus.textContent = `فایل هەڵگیرا: ${file.name}`;
                fileStatus.style.color = 'green';
            } else {
                fileStatus.textContent = 'تکایە تەنها فایلی PDF هەڵبگرە';
                fileStatus.style.color = 'red';
            }
        }
        checkForm();
    });

    // ناردنی فۆرم
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'لە پڕۆسەی ناردندا...';
        
        fetch('save-book.php', {
            method: 'POST',
            body: new FormData(form)
        })
        .then(response => {
            if (!response.ok) throw new Error('هەڵە لە وەڵامدا');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                form.style.display = 'none';
                successMessage.style.display = 'block';
                successMessage.textContent = data.message;
                
                setTimeout(() => {
                    window.location.href = 'books.php';
                }, 3000);
            } else {
                alert(data.message);
                submitBtn.disabled = false;
                submitBtn.textContent = 'زیادکردنی کتێب';
            }
        })
        .catch(error => {
            console.error('هەڵە:', error);
            alert('هەڵەیەک ڕوویدا: ' + error.message);
            submitBtn.disabled = false;
            submitBtn.textContent = 'زیادکردنی کتێب';
        });
    });
});