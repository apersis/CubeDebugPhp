<?php
template('header', array(
    'title' => 'Boite à outils • Accueil',
));

$messages = [];
// Send contact form to database
if (!empty($_POST)) {
    $submited_items = array(
        'name' => htmlspecialchars($_POST['name'],ENT_QUOTES),
        'email' => htmlspecialchars($_POST['email'],ENT_QUOTES),
        'subject' => htmlspecialchars($_POST['subject'],ENT_QUOTES),
        'message' => htmlspecialchars($_POST['message'],ENT_QUOTES),
        'timestamp' => time()+7200
    );

    $validated_items = validate($submited_items, array(
        'name' => array(
            'label' => 'Name',
            'required' => true,
            'sanitize' => 'string',
            'min' => 2,
            'regexp' => '/^[a-zA-Z0-9À-ÿ]+$/'
        ),
        'email' => array(
            'label' => 'Email',
            'required' => true,
            'sanitize' => 'email',
        ),
        'subject' => array(
            'label' => 'Subject',
            'required' => true,
            'sanitize' => 'string',
        ),
        'message' => array(
            'label' => 'Message',
            'required' => true,
            'sanitize' => 'string',
        ),
        'timestamp' => array(
            'label' => 'timestamp',
            'required' => true,
            'sanitize' => 'int',
        )
    ));

    $result = check_validation($validated_items);

    if (!is_passed($result)) {
        $messages = $result;
    } else {
        if(insert('admin_messages', $result)) {
            $messages['success'][] = 'Message envoyé !';
            mail((htmlspecialchars($_POST['email'],ENT_QUOTES)),'Confirmation de reception du formulaire','Bonjour, MyToolBox a bien recu votre message, merci a vous !');
        }
    }
}
?>

    <!-- ======= About Section ======= -->
    <section id="homepage" class="homepage">
        <div class="container">
            <div class="section-title">
                <h2>La boite à outils </h2>
                <p>La boite à outils est un site accessible 24h/24 et 7j/7 qui vous permet de réaliser un bon nombre de calculs ou transformations nécessaires au quotidien.</p>

                <p>Transformer 1/4 de litres en millilitres ou encore convertir des euros en dollars n'a jamais été aussi simple !</p>
            </div>

            <?php 
                getAlert($messages);
             ?>

            <div class="row">
                <div class="col-lg-12 pt-4 pt-lg-0 content">
                    <h3>Il vous manque une fonctionnalité ?</h3>
                    <p class="fst-italic">
                        Écrivez-nous grâce au formulaire de contact et nous vous répondrons dans les plus brefs délais.
                    </p>
                    <form id="contact-form" name="contact-form" method="POST">
                        <!--Grid row-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="md-form mb-0">
                                    <input type="text" id="name" name="name" maxlength="20" class="form-control" placeholder="Votre nom">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="md-form mb-0">
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Votre email (pour vous répondre)">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="md-form mb-0">
                                    <input type="text" id="subject" name="subject" maxlength="255" class="form-control" placeholder="Objet">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="md-form">
                                    <textarea id="message" name="message" rows="4" class="form-control md-textarea" placeholder="Votre demande"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        J'accepte que mes données soient utilisées dans le cadre de demande de fonctionnalité
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="text-center text-md-start">
                                    <button type="submit" class="btn  btn-block btn-primary">Envoyer</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section><!-- End Home Section -->


<?php template('footer');
