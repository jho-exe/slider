<!DOCTYPE html>
<html lang="es">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Administrativo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="styles.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        .image-thumb {
            max-width: 200px;
            max-height: 200px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Panel Administrativo</h1>

    <!-- Formulario para subir una nueva imagen -->
    <div class="card mb-4">
        <div class="card-header">
            Subir Nueva Imagen
        </div>
        <div class="card-body">
            <form action="{{ url('admin/images') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="image" class="form-label">Seleccionar Imagen</label>
                    <input type="file" class="form-control" name="image" id="image" required>
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Duración (en segundos)</label>
                    <input type="number" class="form-control" name="duration" id="duration" required>
                </div>
                <button type="submit" class="btn btn-primary">Subir</button>
            </form>
        </div>
    </div>

    <!-- Lista de imágenes -->
    <div class="card">
        <div class="card-header">
            Lista de Imágenes
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Duración (segundos)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($images as $image)
                        <tr>
                            <td><img src="{{ asset($image->file_path) }}" alt="Imagen" class="img-fluid image-thumb"></td>
                            <td>{{ $image->duration }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <!-- Botón para abrir el modal -->
                                    <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editModal-{{ $image->id }}">Editar</button>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="editModal-{{ $image->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $image->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel-{{ $image->id }}">Editar Duración</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ url('admin/images/' . $image->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="duration-{{ $image->id }}" class="form-label">Duración (en segundos)</label>
                                                            <input type="number" class="form-control" name="duration" id="duration-{{ $image->id }}" value="{{ $image->duration }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin Modal -->
                                    
                                    <!-- Formulario eliminar -->
                                    <form action="{{ url('admin/images/' . $image->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ url('/') }}" class="btn btn-secondary">Ver Slider</a>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        toastr.options.timeOut = 3000;  // 3 segundos

        var message = "{{ session('message', '') }}";
        var type = "{{ session('message_type', '') }}";

        if (message && type) {
            switch (type) {
                case 'success':
                    toastr.success(message);
                    break;
                case 'error':
                    toastr.error(message);
                    break;
                case 'info':
                    toastr.info(message);
                    break;
                case 'warning':
                    toastr.warning(message);
                    break;
                default:
                    console.error('Tipo de mensaje desconocido:', type, 'Por favor use uno de los siguientes: success, error, info, warning.');
                break;
            }
        }

    });
</script>
</body>
</html>
