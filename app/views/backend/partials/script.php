<script src="<?= assets("backend/assets/js/sidebar.js") ?>"></script>
<script src="<?= assets("backend/assets/js/setTheme.js") ?>"></script>
<script src="<?= assets("backend/assets/js/script.js") ?>"></script>

<script src="<?= assets("backend/assets/js/axios.min.js") ?>"></script>
<script src="<?= assets("backend/main.js") ?>"></script>
<script>
    const APP_URL = "<?= APP_URL ?>";
    const API_URL = "<?= API_URL ?>";
</script>

<!-- html2pdf CDN link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

<script>
    function genaratePDF(filename) {
        let file = filename != "" ? filename : Math.round(Date.now());
        let element = document.getElementById('print').innerHTML;

        let opt = {
            margin: [0, 0, 0, 0],
            filename: `${file}.pdf`,
            image: {type: 'png', quality: 0.95},
            html2canvas: {scale: 2, useCORS: true},
            jsPDF: {unit: 'in', format: 'letter', orientation: 'portrait'},
            pagebreak: {before: '.beforeClass'}
        };

        // For save
        // html2pdf().set(opt).from(element).save();

        // For browser output
        html2pdf().set(opt).from(element).toPdf().get('pdf').then(function (pdf) {
            window.open(pdf.output('bloburl'), '_blank');
        });
    }
    

</script>