<?php
template('header', array(
    'title' => 'Boite à outils • Accueil',
));

$messages = select('admin_messages');
$logs = select('logs');

?>

<section id="homepage" class="homepage">
    <div class="container">
        <div class="section-title">
            <h2>Espace adminstrateur</h2>
        </div>

        <div class="row">
            <div class="col-lg-12 pt-4 pt-lg-0 content">
                <h3>Messages reçus depuis le formulaire de contact</h3>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Objet</th>
                                <th scope="col">Message</th>
                                <th scope="col">Date/Heure</th>
                            </tr>
                            </thead>
                            <tbody id="ferme1">
                            <?php 
                            $messages=array_reverse($messages);
                            for ($i=0;$i<5;$i++){ ?>
                                <tr>
                                    <th scope="row"><?php echo $messages[$i]['id']; ?></th>
                                    <td><?php echo $messages[$i]['name']; ?></td>
                                    <td><?php echo $messages[$i]['email']; ?></td>
                                    <td><?php echo $messages[$i]['subject']; ?></td>
                                    <td><?php echo $messages[$i]['message']; ?></td>
                                    <td><?php echo date("d/m/Y - H:i:s",$messages[$i]['timestamp']); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                            <tbody id="ouvert1">
                            <?php 
                            foreach ($messages as $message): ?>
                                <tr>
                                    <th scope="row"><?php echo $message['id']; ?></th>
                                    <td><?php echo $message['name']; ?></td>
                                    <td><?php echo $message['email']; ?></td>
                                    <td><?php echo $message['subject']; ?></td>
                                    <td><?php echo $message['message']; ?></td>
                                    <td><?php echo date("d/m/Y - H:i:s",$message['timestamp']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button id="more1">Afficher <span id="plus1">plus</span><span id="moins1">moins</span></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-12 pt-4 pt-lg-0 content">
                <h3>Logs</h3>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Formulaire</th>
                                <th scope="col">Data</th>
                                <th scope="col">Result</th>
                                <th scope="col">Date/Heure</th>
                            </tr>
                            </thead>
                            <tbody id="ferme2">
                            <?php 
                            $logs=array_reverse($logs);
                            for($i=0;$i<5;$i++){ ?>
                                <tr>
                                    <th scope="row"><?php echo $logs[$i]['id']; ?></th>
                                    <td><?php echo $logs[$i]['form']; ?></td>
                                    <td><?php echo $logs[$i]['data']; ?></td>
                                    <td><?php echo $logs[$i]['result']; ?></td>
                                    <td><?php echo date("d/m/Y - H:i:s",$logs[$i]['timestamp']); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                            <tbody id="ouvert2">
                            <?php 
                            foreach ($logs as $log): ?>
                                <tr>
                                    <th scope="row"><?php echo $log['id']; ?></th>
                                    <td><?php echo $log['form']; ?></td>
                                    <td><?php echo $log['data']; ?></td>
                                    <td><?php echo $log['result']; ?></td>
                                    <td><?php echo date("d/m/Y - H:i:s",$log['timestamp']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button id="more2">Afficher <span id="plus2">plus</span><span id="moins2">moins</span></button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
let btn1 = document.getElementById("more1");
let ferme1 = document.getElementById("ferme1");
let ouvert1 = document.getElementById("ouvert1");
let btn2 = document.getElementById("more2");
let ferme2 = document.getElementById("ferme2");
let ouvert2 = document.getElementById("ouvert2");
let plus1 = document.getElementById("plus1");
let moins1 = document.getElementById("moins1");
let plus2 = document.getElementById("plus2");
let moins2 = document.getElementById("moins2");

var i=0;

function OpenNav1() { //Fonction pour ouvrir (et fermer) le menu
    if (i%2==1) {
        ferme1.style.display = "contents";
        ouvert1.style.display = "none";
        plus1.style.display = "contents";
        moins1.style.display = "none";
        i++;
    } else {
        ferme1.style.display = "none";
        ouvert1.style.display = "contents";
        plus1.style.display = "none";
        moins1.style.display = "contents";
        i++;
    }
};

var j=0;

function OpenNav2() { //Fonction pour ouvrir (et fermer) le menu
    if (j%2==1) {
        ferme2.style.display = "contents";
        ouvert2.style.display = "none";
        plus2.style.display = "contents";
        moins2.style.display = "none";
        j++;
    } else {
        ferme2.style.display = "none";
        ouvert2.style.display = "contents";
        plus2.style.display = "none";
        moins2.style.display = "contents";
        j++;
    }
};

btn1.onclick = OpenNav1; // La fonction se declanche au clique
btn2.onclick = OpenNav2; // La fonction se declanche au clique
</script>

<style>
#ouvert1{
    display:none;
}
#ouvert2{
    display:none;
}
#moins1{
    display:none;
}
#moins2{
    display:none;
}
</style>


<?php template('footer');
