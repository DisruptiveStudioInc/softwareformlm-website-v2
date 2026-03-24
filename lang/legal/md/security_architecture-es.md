# **ARQUITECTURA DE SEGURIDAD Y VISIÓN TÉCNICA**

### **VISIÓN GENERAL**

Este documento proporciona una visión general de alto nivel de la arquitectura de seguridad utilizada para respaldar los Servicios alojados por Disruptive Studio. Su propósito es describir principios generales, capas técnicas y controles operativos sin divulgar información sensible que pudiera comprometer la seguridad.

La arquitectura descrita puede evolucionar con el tiempo como parte de mejoras continuas, cambios de infraestructura y requisitos operativos o regulatorios.

### **ARQUITECTURA**

La arquitectura de la plataforma se diseña en torno a principios de segmentación, control de acceso, visibilidad operativa y defensa en profundidad.

Los entornos se estructuran para separar responsabilidades entre capas de aplicación, infraestructura, monitoreo y administración, reduciendo la exposición innecesaria y favoreciendo la trazabilidad de actividades.

### **INFRAESTRUCTURA EN LA NUBE**

Los Servicios pueden alojarse en infraestructura en la nube administrada por proveedores externos seleccionados por Disruptive Studio.

El uso de infraestructura en la nube permite escalabilidad, disponibilidad operativa, redundancia y capacidades de recuperación acordes con las necesidades del servicio; sin embargo, parte de la arquitectura depende de controles y disponibilidad de terceros.

### **SEGURIDAD DE RED**

La arquitectura puede apoyarse en controles de red apropiados al contexto del servicio, incluyendo segmentación, filtrado de tráfico, exposición limitada de servicios y controles perimetrales razonables.

Estos controles buscan reducir superficies de ataque y limitar accesos innecesarios entre componentes.

### **CONTROL DE ACCESO**

El acceso a sistemas, herramientas administrativas y recursos operativos se restringe conforme a principios de mínimo privilegio y necesidad operativa.

La asignación de accesos se revisa de manera razonable según roles, responsabilidades y necesidades vigentes.

### **SEGURIDAD DE DATOS**

Disruptive Studio procura aplicar salvaguardas administrativas, técnicas y organizativas apropiadas para proteger datos dentro del alcance de sus Servicios.

Dependiendo del contexto, estas medidas pueden incluir cifrado, controles basados en roles, separación lógica, procedimientos de respaldo y prácticas de manejo seguro de credenciales y secretos.

### **MONITOREO Y OBSERVABILIDAD**

La arquitectura incorpora mecanismos de observabilidad y monitoreo para apoyar la detección de fallas, anomalías operativas y posibles incidentes de seguridad.

Estos mecanismos ayudan a mantener conciencia situacional sobre salud del sistema, desempeño y eventos relevantes para la operación.

### **REGISTROS Y AUDITORÍA**

Se pueden conservar registros técnicos y operativos para respaldar diagnóstico, investigación de incidentes, trazabilidad y revisión interna.

La disponibilidad y granularidad de dichos registros puede variar según el componente, el entorno y las limitaciones técnicas aplicables.

### **OPERACIONES DE SEGURIDAD**

Las operaciones de seguridad se orientan a revisión, mantenimiento y respuesta razonable frente a eventos que puedan afectar la confidencialidad, integridad o disponibilidad de la plataforma.

Disruptive Studio puede ajustar herramientas, procesos y controles de operación conforme evolucione la plataforma.

### **GESTIÓN DE VULNERABILIDADES**

Disruptive Studio puede realizar revisiones internas, actualizaciones, parches y otras acciones razonables destinadas a reducir exposición frente a vulnerabilidades conocidas o riesgos emergentes.

La remediación y priorización dependerán de severidad, impacto operativo y factibilidad técnica.

### **RESPUESTA A INCIDENTES**

En caso de incidentes que afecten los Servicios, Disruptive Studio podrá aplicar procesos internos de contención, investigación, mitigación y recuperación de acuerdo con la naturaleza del evento.

Cuando corresponda, podrá comunicarse información relevante por los canales considerados apropiados.

### **SEGURIDAD DE APLICACIONES**

La capa de aplicación se diseña con el objetivo de limitar accesos indebidos, proteger flujos críticos y reducir errores que puedan comprometer operaciones o datos.

Disruptive Studio podrá modificar la aplicación, sus dependencias o sus configuraciones de seguridad como parte del mantenimiento continuo del servicio.

### **DISPONIBILIDAD Y RESILIENCIA**

La arquitectura busca favorecer resiliencia operativa y continuidad razonable del servicio, pero no garantiza disponibilidad absoluta ni operación ininterrumpida.

Eventos de mantenimiento, incidencias técnicas, fallas de terceros o condiciones fuera de control razonable pueden afectar temporalmente la disponibilidad.

### **DEPENDENCIAS DE TERCEROS**

Algunos componentes, herramientas o capacidades de la arquitectura pueden depender de proveedores externos, incluyendo hosting, monitoreo, entrega de contenido, identidad o pagos.

Disruptive Studio no garantiza que los entornos de terceros estén libres de fallas, interrupciones o retrasos.

### **ALINEACIÓN DE CUMPLIMIENTO**

La arquitectura puede diseñarse y operarse con referencia a principios generales de seguridad, gestión de riesgos y buenas prácticas de la industria, en la medida razonablemente apropiada para la naturaleza de los Servicios.

Esto no debe interpretarse como certificación automática de un estándar específico salvo que exista declaración expresa por escrito.

### **MODELO DE RESPONSABILIDAD COMPARTIDA**

La seguridad de la plataforma es una responsabilidad compartida. Disruptive Studio gestiona controles dentro del alcance de sus Servicios, mientras que los clientes siguen siendo responsables de sus usuarios, dispositivos, configuraciones, accesos internos, operaciones y cumplimiento propio.

**LIMITACIONES**

Este documento tiene fines informativos y no constituye garantía, certificación, compromiso contractual independiente ni divulgación exhaustiva de controles técnicos.

### **CONCLUSIÓN**

Disruptive Studio revisa y mejora continuamente sus prácticas y arquitectura de seguridad conforme evolucionan los Servicios, las amenazas y los requisitos operativos. Los clientes deben considerar este documento como una visión general de principios y no como una descripción completa de cada control implementado.
