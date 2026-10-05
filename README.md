# Council Digital Service Improvement

A Drupal-based digital service prototype demonstrating how local government services can be structured, managed, and published using reusable content models.

The project uses Drupal 11, MariaDB, Docker, Docker Compose, Drush, and Git-based configuration management to create a reproducible council digital services environment.

## Project Overview

Council websites provide information across many service areas, including Council Tax, benefits, waste and recycling, housing, planning, and transport.

When service information is managed without a consistent structure, content can become difficult to maintain and harder for residents to understand.

This project demonstrates a reusable Drupal content model for publishing council services in a consistent and user-focused format.

A custom **Council Service** content type was created so different council services can use the same structured fields while maintaining their own service information.

## Objectives

The project was designed to demonstrate:

- Structured content modelling with Drupal
- Reusable digital service components
- User-focused public service information
- Drupal configuration management
- Containerised local development
- Database-backed content management
- Environment-based configuration
- Secure handling of local credentials
- Git version control
- Reproducible development environments

## Technology Stack

| Technology | Purpose |
| --- | --- |
| Drupal 11 | Content management and digital service platform |
| PHP | Drupal application runtime |
| MariaDB 11.4 | Relational database |
| Apache | Web server |
| Docker | Application containerisation |
| Docker Compose | Multi-container orchestration |
| Drush | Drupal command-line and configuration management |
| YAML | Drupal configuration |
| Git | Version control |

## Architecture

The local development environment consists of two main containers:

```text
Browser
   |
   | http://localhost:8080
   v
+-------------------------+
| Drupal 11 + Apache      |
| council-drupal          |
+------------+------------+
             |
             | Database connection
             v
+-------------------------+
| MariaDB 11.4            |
| council-drupal-db       |
+-------------------------+
```

Docker named volumes provide persistent storage for Drupal files and database data.

## Council Service Content Model

The main feature of the project is a reusable Drupal content type called:

**Council Service**

Instead of creating a different structure for every council department, services use a common content model.

The model includes:

| Field | Purpose |
| --- | --- |
| Service title | Name of the council service |
| Service category | Groups the service into a council service area |
| Service summary | Provides a short user-focused description |
| Service description | Provides detailed service information |
| Eligibility information | Explains who may use or qualify for the service |
| Service location | Identifies the relevant service location |
| Contact information | Provides the responsible council contact |
| Service URL | Directs users to the relevant online service or application |

This approach improves consistency and makes service information easier to maintain and reuse.

## Service Categories

The content model supports multiple council service areas, including:

- Benefits
- Council Tax
- Housing
- Planning
- Waste and Recycling
- Roads and Transport

The same Drupal content type can therefore support many different public services without creating separate content structures for every department.

## Demonstration Services

Three representative council services were created to demonstrate reuse of the content model.

### Council Tax Support

Provides residents with information about obtaining help with Council Tax when they are on a low income or receive qualifying benefits.

The service demonstrates:

- Benefits categorisation
- Eligibility information
- Council contact details
- Location information
- External application guidance

### Report a Missed Bin Collection

Provides residents with information for dealing with a missed household waste collection.

The service demonstrates how the same content model can support a different operational council department using the **Waste and Recycling** category.

### Apply for a Resident Parking Permit

Provides information for residents who need to apply for a parking permit.

The service is categorised under **Roads and Transport**, demonstrating how transport-related services can use the same reusable structure.

## Drupal Configuration Management

Drupal configuration was exported using Drush and stored in the repository under:

```text
config/
```

Examples include:

```text
config/node.type.council_service.yml

config/field.field.node.council_service.field_service_category.yml
config/field.field.node.council_service.field_service_summary.yml
config/field.field.node.council_service.field_service_description.yml
config/field.field.node.council_service.field_eligibility_information.yml
config/field.field.node.council_service.field_service_location.yml
config/field.field.node.council_service.field_contact_information.yml
config/field.field.node.council_service.field_service_url.yml
```

Form and display configuration is also version controlled:

```text
config/core.entity_form_display.node.council_service.default.yml
config/core.entity_view_display.node.council_service.default.yml
```

This means the Drupal content architecture is represented as code and can be reviewed and version controlled with Git.

## Configuration Export

Drush is used to export active Drupal configuration.

Example:

```bash
vendor/bin/drush config:export -y
```

The exported YAML files can then be maintained through Git rather than relying only on configuration stored in the Drupal database.

## Environment Configuration

Database credentials are not committed to the repository.

Docker Compose reads database configuration from environment variables:

```yaml
MARIADB_DATABASE: ${MARIADB_DATABASE}
MARIADB_USER: ${MARIADB_USER}
MARIADB_PASSWORD: ${MARIADB_PASSWORD}
MARIADB_ROOT_PASSWORD: ${MARIADB_ROOT_PASSWORD}
```

A safe template is provided:

```text
.env.example
```

Developers create their own local `.env` file from this template.

The real `.env` file is excluded through `.gitignore`.

## Running the Project

### Prerequisites

Install:

- Docker Desktop
- Docker Compose
- Git

### 1. Clone the repository

```bash
git clone <repository-url>
cd council-digital-service-improvement
```

### 2. Create the environment file

Copy:

```text
.env.example
```

to:

```text
.env
```

Then replace the placeholder passwords with local development values.

Example:

```env
MARIADB_DATABASE=drupal
MARIADB_USER=drupal
MARIADB_PASSWORD=your_local_password
MARIADB_ROOT_PASSWORD=your_local_root_password
```

Do not commit the `.env` file.

### 3. Start the containers

```bash
docker compose up -d
```

### 4. Check container status

```bash
docker compose ps
```

The Drupal application is exposed locally on:

```text
http://localhost:8080
```

## Docker Services

The environment contains:

### Drupal

```text
Image: drupal:11-apache
Container: council-drupal
Port: 8080 -> 80
```

### Database

```text
Image: mariadb:11.4
Container: council-drupal-db
Port: 3306 (internal)
```

The database includes a health check, and Drupal waits for the database service to become healthy.

## Security Considerations

The repository follows several basic configuration security practices:

- Database passwords are stored outside version control.
- `.env` is ignored by Git.
- `.env.example` contains only safe placeholder values.
- Database data is stored in Docker volumes rather than committed to Git.
- Generated Drupal public files are excluded from source control.
- Database dumps are excluded through `.gitignore`.
- Drupal configuration is version controlled separately from application content and secrets.

## Project Structure

```text
council-digital-service-improvement/
|
|-- config/
|   |-- node.type.council_service.yml
|   |-- field.field.node.council_service.*
|   |-- field.storage.node.*
|   |-- core.entity_form_display.*
|   |-- core.entity_view_display.*
|   `-- other Drupal configuration
|
|-- .env.example
|-- .gitignore
|-- docker-compose.yml
`-- README.md
```

## Content Design Approach

The Council Service content type encourages service information to be:

- Structured
- Consistent
- Easy to maintain
- Written in clear language
- Focused on the user's task
- Reusable across different council service areas

The prototype demonstrates how a CMS can support consistent digital service publishing rather than treating each council page as an unrelated piece of content.

## Skills Demonstrated

This project demonstrates practical experience with:

**Drupal**
- Content types
- Custom fields
- Content modelling
- Form configuration
- Display configuration
- Publishing workflows
- Drupal configuration management
- Drush

**Backend and Data**
- MariaDB
- Database-backed CMS architecture
- Environment configuration
- Persistent Docker volumes

**DevOps**
- Docker
- Docker Compose
- Container networking
- Health checks
- Environment variables
- Git configuration management

**Software Engineering**
- Reusable content architecture
- Separation of configuration and content
- Version control
- Secure configuration practices
- Reproducible development environments
- Technical documentation

## Future Improvements

Possible future enhancements include:

- Custom Drupal theme for council branding
- Service search and filtering
- Service category landing pages
- Automated accessibility testing
- Drupal automated tests
- CI/CD pipeline
- Production container configuration
- Custom Drupal module development
- API-based service delivery
- Automated configuration import during deployment

## Portfolio Context

This project was developed as a practical software engineering and digital service demonstration.

It focuses on how structured content, reusable architecture, configuration management, containerisation, and secure development practices can be applied to a realistic local-government digital service scenario.

The three demonstration services intentionally represent different council service areas to show that the underlying content architecture is reusable rather than tied to a single service.

## Author

**Samuel Sesay**

Software Engineer / Full-Stack Developer

Technologies include Java, Spring Boot, React, Node.js, SQL, Docker, cloud platforms, CI/CD, DevSecOps, Drupal and modern web development.