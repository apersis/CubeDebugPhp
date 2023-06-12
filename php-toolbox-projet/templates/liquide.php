<?php
template('header', array(
    'title' => 'Boite à outils • Liquide',
));
?>

    <!-- ======= About Section ======= -->
    <section id="homepage" class="homepage">
        <div class="container">
            <div class="section-title">
                <h2>Convertisseur de volume</h2>
            </div>

            <div class="row">

                <fieldset class="col-12 mt-4">
                    <legend>Convertisseur de Litre</legend>
                    <form action="" method="post" name="liquide">
                        <div class="form-group row padding">
                            <div class="col">
                                <label for="from" aria-hidden="true" hidden>Depuis</label>
                                <div class="input-group">
                                    <input id="from" name="from" type="text" class="form-control" required>
                                    <div class="input-group-append">
                                        <select name="fromliquide" id="from-liquide-select" style="height: 100%;">
                                            <option value="">Volume</option>
                                            <option value="1000">Metre Cube</option>
                                            <option value="1000">Kilolitre</option>
                                            <option value="100">Hectolitre</option>
                                            <option value="10">Décalitre</option>
                                            <option value="1">Litre</option>
                                            <option value="0.1">Decilitre</option>
                                            <option value="0.01">Centilitre</option>
                                            <option value="0.001">Millilitre</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-inline-flex align-items-center" id="widthauto">
                                <span class="ver">vaut</span>
                            </div>

                            <div class="col">
                                <label for="result" aria-hidden="true" hidden>Vers</label>
                                <div class="input-group">
                                    <input id="result" name="result" type="text" class="form-control" disabled>
                                    <div class="input-group-append">
                                        <select name="toliquide" id="to-liquide-select" style="height: 100%;">
                                            <option value="">Volume</option>
                                            <option value="1000">Metre Cube</option>
                                            <option value="1000">Kilolitre</option>
                                            <option value="100">Hectolitre</option>
                                            <option value="10">Décalitre</option>
                                            <option value="1">Litre</option>
                                            <option value="0.1">Decilitre</option>
                                            <option value="0.01">Centilitre</option>
                                            <option value="0.001">Millilitre</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <button name="submit" type="submit" class="btn btn-primary btn-block">Calculer</button>
                            </div>
                        </div>
                    </form>
                </fieldset>
                </div>
            </div>
    </section><!-- End Home Section -->


    <script type="text/javascript">
        window.addEventListener('load', () => {
            let forms = document.forms;

            for(form of forms){
                form.addEventListener('submit', async (event) => {
                    event.preventDefault();

                    const formData = new FormData(event.target).entries()

                    const response = await fetch('/api/post', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(
                            Object.assign(Object.fromEntries(formData), {form: event.target.name})
                        )
                    });

                    const result = await response.json();

                    let inputName = Object.keys(result.data)[0];
                    
                    event.target.querySelector(`input[name="${inputName}"]`).value = result.data[inputName];
                    
                })
            }
        });
    </script>

<?php template('footer');
