@component('mail::message')
    # Backup Creado Correctamente

    Hola,

    Se ha creado un nuevo backup correctamente en el sistema.

    ## Detalles del backup:
    - **Fecha:** {{ $backupDate }}
    - **Hora:** {{ $backupTime }}
    - **Tamaño:** {{ $backupSize }} MB

    Gracias por usar nuestro sistema.

    Saludos,<br>
    {{ config('app.name') }} Team
@endcomponent
