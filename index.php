<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mireseerdhe</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <style>
        body {
            overflow: auto;
            text-align: center;
        }

        .table-striped td, th {
            font-size: 14pt;
            padding-bottom: 8px;
            padding-top: 8px;
            padding-left: 10px;
        }

        .container, .container .table-striped {
            width: 90vw;
            margin-left: 25px;
            margin-right: auto;
            text-align: left;
        }
    </style>
    <script>
        function ruajklient() {
            var emri = $('#klientEmer').val();
            var mbiemri = $('#klientMbiemer').val();
            var numri = $('#klientNr').val();
            var email = $('#klientEmail').val();

            $.ajax({
                type: "POST",
                url: "tabela.php",
                data: {
                    'emri': emri,
                    'mbiemri': mbiemri,
                    'numri': numri,
                    'email': email,
                    'action': 'ruaj'
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 200) {
                        window.local.href = "http://localhost/lavazho/index.php#";
                    } else {
                        window.alert("Nuk u ruajt!");
                    }
                }
            });
        }


    </script>
</head>
<body>
<div class="container">
    <h4 class="mt-4">Pershendetje, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Mireseerdhe te faqja
        jone.
        <span style="position: absolute; right: 50px">
        <a href="reset-password.php" class="ml-3 btn btn-warning">Reset Password</a>
        <a href="logout.php" class="btn btn-danger">Dil nga llogaria</a>
        </span>
    </h4><br>
    <h4 class="ml-5">Tabela e klienteve</h4>
    <table class="table-striped">
        <thead>
        <tr>
            <th scope="row">Emri</th>
            <th scope="row">Mbiemri</th>
            <th scope="row">Numri i celularit</th>
            <th scope="row">Email</th>
        </tr>
        </thead>
        <tbody id="table">

        </tbody>
    </table>
    <div class="ml-4 mt-4">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#krijoKlientModal">
            Krijo klient
        </button>
        <a href="#" type="button" class="btn btn-success">Kerko</a>
    </div>


    <!-- Modal -->
    <div class="modal fade overflow-auto" id="krijoKlientModal" tabindex="-1" role="dialog"
         aria-labelledby="krijoKlientModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Krijo klient</p>

                    <div class="mx-1 mx-md-4">

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <label class="form-label" for="form3Example1c">Emri</label>
                                <input type="text" id="klientEmer" class="form-control"/>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <label class="form-label" for="form3Example3c">Mbiemri</label>
                                <input type="text" id="klientMbiemer" class="form-control"/>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <label class="form-label" for="form3Example4c">Numri i telefonit</label>
                                <input type="text" id="klientNr" class="form-control"/>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <label class="form-label" for="form3Example4cd">Email</label>
                                <input type="email" id="klientEmail" class="form-control"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Mbyll</button>
                    <button type="button" class="btn btn-primary" id="regjistroButon" onclick="ruajklient()">Regjistro
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>

        $.ajax({
            url: "tabela.php",
            type: "POST",
            cache: false,
            success: function (data) {
                $('#table').html(data);
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</div>
</body>
</html>