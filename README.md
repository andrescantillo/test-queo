# Instalación de test-queo-front

## Project setup

```
cd test-queo-back
```

```
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Lints and fixes files
```
npm run lint
```

### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).



# Instalación de test-queo-back

### Pre-requisitos 

_Que cosas necesitas para poner en marcha el proyecto y como instalarlos_

* GIT [Link](https://git-scm.com/downloads)
* Entorno de servidor local, Ej: [Laragon](https://laragon.org/download/), [XAMPP](https://www.apachefriends.org/es/index.html) o [LAMPP](https://bitnami.com/stack/lamp/installer).
* PHP Version 8.0 [Link](https://www.php.net/downloads.php).
* Manejador de dependencias de PHP [Composer](https://getcomposer.org/download/).

### Instalación 🔧

Paso a paso de lo que debes ejecutar para tener el proyecto ejecutandose

 1. Ingrese a la carpeta del repositorio
    ```
    cd test-queo-back
    ```
 2. Instale las dependencias del proyecto
    ```
    composer install
    ```
 3. Cree el archivo ".env" y cambie valores de base de datos.
 4. Ejecute las migraciones
    ```
    php artisan migrate --seed
    ```
 5. Inicialice el servidor local
    ```
    php artisan serve --port=8080
    ```  
 6. Validar pruebas
   ```
    php artisan test
   ```

## Construido con 🛠️

* Framework de PHP [Laravel](https://laravel.com/docs/9.x).