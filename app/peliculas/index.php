<?php
require '../config/database.php';

$sqlpeliculas = "SELECT p.id, p.nombre, p.descripcion, g.nombre AS genero FROM pelicula AS p
 INNER JOIN genero AS g ON p.id_genero=g.id";

$peliculas = $conn->query($sqlpeliculas);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-3">
        <h2 class="text-center">Peliculas</h2>

        <div class="row justify-content-end">
            <div class="col-auto">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoModal"><i class="fa-solid fa-circle-plus"></i>
                    Nuevo Registro</a>
            </div>
        </div>

        <table class="table table-sm table-striped table-hover mt-4">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Género</th>
                    <th>Poster</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $peliculas->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['nombre']; ?></td>
                        <td><?= $row['descripcion']; ?></td>
                        <td><?= $row['genero']; ?></td>
                        <td><img src="<?= $dir . $row['id'] . '.jpg?n=' . time(); ?>" width="100"></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editaModal" data-bs-id="<?= $row['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Editar</a>

                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-id="<?= $row['id']; ?>"><i class="fa-solid fa-trash"></i></i> Eliminar</a>
                        </td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php
    $sqlGenero = "SELECT id, nombre FROM genero";
    $generos = $conn->query($sqlGenero);
    ?>

    <?php include 'nuevoModal.php'; ?>
    
    <?php include 'eliminaModal.php'; ?>
    
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        let nuevoModal = document.getElementById('nuevoModal')
        let editaModal = document.getElementById('editaModal')
        let eliminaModal = document.getElementById('eliminaModal')


        nuevoModal.addEventListener('shown.bs.modal', event => {
            nuevoModal.querySelector('.modal-body #nombre').focus()

        })

        nuevoModal.addEventListener('hide.bs.modal', event => {
            nuevoModal.querySelector('.modal-body #nombre').value = ""
            nuevoModal.querySelector('.modal-body #descripcion').value = ""
            nuevoModal.querySelector('.modal-body #genero').value = ""
            nuevoModal.querySelector('.modal-body #poster').value = ""
        })

        editaModal.addEventListener('hide.bs.modal', event => {
            editaModal.querySelector('.modal-body #nombre').value = ""
            editaModal.querySelector('.modal-body #descripcion').value = ""
            editaModal.querySelector('.modal-body #genero').value = ""
            editaModal.querySelector('.modal-body #img_poster').value = ""
            editaModal.querySelector('.modal-body #poster').value = ""
        })

        editaModal.addEventListener('shown.bs.modal', event => {
            let butoon = event.relatedTarget
            let id = butoon.getAttribute('data-bs-id')
            let inputId = editaModal.querySelector('.modal-body #id')
            let inputNombre = editaModal.querySelector('.modal-body #nombre')
            let inputDescripcion = editaModal.querySelector('.modal-body #descripcion')
            let inputGenero = editaModal.querySelector('.modal-body #genero')
            let poster = editaModal.querySelector('.modal-body #poster')

            let url = "getpelicula.php"
            let formData = new formData()
            formData.append('id', id)

            fetch(url, {
                    methon: "POST",
                    body: formData
                }).then(response => response.json())
                .then(data => {
                    inputId.value = data.id
                    inputNombre.value = data.nombre
                    inputDescripcion.value = data.descripcion
                    inputGenero.value = data.id_genero
                    poster.src = '<? $dir ?>' + data.id + '.jpg'
                }).catch(err => console.log(err))

        })

        eliminaModal.addEventListener('shown.bs.modal', event => {
            let butoon = event.relatedTarget
            let id = butoon.getAttribute('data-bs-id')
            eliminaModal.querySelector('.modal-footer #id').value = id
        })
    </script> 
    
    



</body>

</html>