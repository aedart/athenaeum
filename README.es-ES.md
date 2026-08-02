

[![Latest Stable Version](https://poser.pugx.org/aedart/athenaeum/v/stable)](https://packagist.org/packages/aedart/athenaeum)
[![Total Downloads](https://poser.pugx.org/aedart/athenaeum/downloads)](https://packagist.org/packages/aedart/athenaeum)
[![Latest Unstable Version](https://poser.pugx.org/aedart/athenaeum/v/unstable)](https://packagist.org/packages/aedart/athenaeum)
[![License](https://poser.pugx.org/aedart/athenaeum/license)](https://packagist.org/packages/aedart/athenaeum)
[![Build Status](https://github.com/aedart/athenaeum/actions/workflows/tests.yaml/badge.svg?branch=main)](https://github.com/aedart/athenaeum/actions/workflows/tests.yaml)

# Athenaeum

Athenaeum es un [monorepositorio](https://en.wikipedia.org/wiki/Monorepo); una colección de varios paquetes. 
La mayoría se basan en componentes bien conocidos, como los ofrecidos por [Laravel](https://laravel.com/).
Algunos de los paquetes ofrecidos son:

**[Config](https://aedart.github.io/athenaeum/archive/current/config/)**

_Un cargador de configuración, que admite *.ini, *.json, *.php, *.yml, *.toml y *.neon._

**[Core](https://aedart.github.io/athenaeum/archive/current/core/)**

_Una implementación personalizada de Laravel Application, destinada a pruebas, experimentación o desarrollo de aplicaciones personalizadas no esenciales._

**[Circuits](https://aedart.github.io/athenaeum/archive/current/circuits)**

_Un Circuit Breaker para encapsular la lógica de prevención de fallos._

**[Dto](https://aedart.github.io/athenaeum/archive/current/dto/)**

_Abstracción de objetos de transferencia de datos (DTO)._

**[ETags](https://aedart.github.io/athenaeum/archive/current/etags/)**

_Utilidades para la evaluación de ETags y solicitudes HTTP condicionales._

**[Http Clients](https://aedart.github.io/athenaeum/archive/current/http/clients/)** 

_Envoltorio para clientes HTTP, con un gestor capaz de manejar múltiples "perfiles"._

**[Support](https://aedart.github.io/athenaeum/archive/current/support/)**

_Helpers compatibles con Laravel y DTOs._

## No es un framework

Athenaeum no debe confundirse con un framework, a pesar de la cantidad de paquetes que ofrece.
Los paquetes son simplemente auxiliares y utilidades...

# Cómo instalar

```console
composer require aedart/athenaeum
```

# Documentación oficial

Consulte la [documentación oficial](https://aedart.github.io/athenaeum/) para obtener información adicional.

## Versionado

Este paquete sigue las normas de [Versionado Semántico 2.0.0](http://semver.org/)

## Licencia

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Lea el archivo LICENSE incluido en este paquete
