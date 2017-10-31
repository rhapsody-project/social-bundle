RhapsodyNews
============

The example application for the Rhapsody Social bundle.

Rhapsody News is a dummy application and is designed first as a multi-purpose
functional test of the `Rhapsody\SocialBundle` that follows design patterns
leveraged by the Symfony Framework.

In addition the `RhapdsodyNews` test application functions as a sample for how
one might integrate the social features of `Rhapsody\SocialBundle` into their
own application.

 
## Prerequisites

TBW


## Installation

TBW


## Running / Development

TBW, see: https://symfony.com/doc/current/setup/built_in_web_server.html


## Testing

### Test Configurations

If we want to test different sets of functionality within the bundle that may be
impossible to configure simultaneously (e.g. database backend configurations,
firewalls, etc.) we would typically need to define an application for each
configuration type. Creating an application per configuration is not a menial
task. Instead, we create different test configuration "contexts" that can be
loaded by the testing framework to make a single application and bundle
combination behave differently, depending on the set of test configurations
used.

We store our test configurations under `app\config\tests` and name them
appropriately, e.g. `MongoDB`, or `ORM` for different database testing contexts.

Current testing configurations are:

- `config/tests/MongoDB`
- `config/tests/ORM`
