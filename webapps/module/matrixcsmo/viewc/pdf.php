<style type="text/css">
#pdf {
    border: 0px;
    padding: 0px;
    margin: 0px;
}

html, body, frame {
    border: 0px;
    padding: 0px;
    margin: 0px;
}

#gview {
    width: 99.7%;
    height: 98.8%;
}

</style>
<!-- embed pdf file -->
<div id="pdf">
    <!-- <object data="<?php echo $data['filename']; ?>?#zoom=80&toolbar=0&navpanes=0&scrollbar=0" type="application/x-pdf" title="mxtcsmo" width="100%" height="100%">
        <p>El PDF no puede ser visualizado, debe tener instalado el plugin de Acrobat Reader en su navegador</p>
        <embed src="<?php echo $data['filename']; ?>#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="100%">
    </object> -->
    <iframe id="gview" src="https://docs.google.com/gview?url=http://vatia.co/mtx_csmo_1000946_jjjuctbnvvnho0kttfud38a2v2.pdf&embedded=true"></iframe>
</div>

