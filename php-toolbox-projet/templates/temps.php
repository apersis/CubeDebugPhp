<?php
template('header', array(
    'title' => 'Boite à outils • Temps',

));
?>

    <!-- ======= CESAR ======= -->
    <section id="homepage" class="homepage">
        <div class="container">
            <div class="section-title">
                <h2> Additionner des heures et des minutes </h2>
            </div>

            <div class="row">
                <figure class="bg-light rounded p-3">
                    <blockquote>
                        <p>
                            Cette page vous permet d'additionner et de soustraire des temps au format "1h23m45s+59m15s-56s"
                        </p>
                    </blockquote>
                </figure>
            </div>

            <div class="row justify-content-around">
                <fieldset class="col-10 mt-4">
                    <legend>Additionner et Soustraire</legend>
                    <form action="" method="POST" name="temps">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="clear">Le temps à additionner</label>
                                <div class="input-group">
                                    <textarea id="clear" name="clear" rows="10" class="form-control" required></textarea>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <label for="result">Résultat</label>
                                <p id="result"></p>
                            </div>
                        </div>

                        <div class="form-group row padding">
                            <div class="col-12">
                                <button type="submit" class="btn-block btn btn-primary">Calculer</button>
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
</section>

<style>
#clear{
    overflow:auto;
    overflow-wrap: break-word;
}
#result{
    overflow:auto;
    overflow-wrap: break-word;
}
</style>

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
                const result = await response.json(); // ICI CA BUG QUOTES
                let inputName = Object.keys(result.data)[0];

                event.target.querySelector(`#${inputName}`).innerHTML= result.data[inputName];
                

            })
        }
    });
</script>


<?php template('footer');
