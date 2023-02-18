<section class="main">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Imię</td>
                                <td>Nazwisko</td>
                                <td>Adres e-mail</td>
                                <td>Numer telefonu</td>
                                <td>Adres fizyczny</td>
                                <td>Data dodania</td>
                                <td>Data modyfikacji</td>
                                <td></td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php echo $data['bookRecordsList']; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>