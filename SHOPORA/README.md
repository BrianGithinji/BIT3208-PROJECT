BIT3208: Advanced Web Design and Development Course Outline Weekly Breakdown into practical project with Tools and key concepts.

Purpose:
Guide Student in obtaining the objective, research and gain key skills in the market currently. 

Weekly Breakdown Table
Week	Topics / Activities	Practical Focus	Assessment	Key Recommended Tools
1	Fundamentals of Networking (Sockets, IP, TCP, HTTP)	Setting up a local server and testing HTTP requests	–	Wireshark, Postman
2	Client-side Components (HTML, XML, Browsers, Applets)	Building structured HTML/XML pages	–	VS Code, Chrome DevTools
3	JavaScript & VBScript Basics	DOM manipulation, form validation	–	Node.js, ESLint
4	Server-side Components (Web servers, Servlets, CGI, PHP, ASP)	Deploying a simple PHP/ASP script	–	XAMPP/WAMP, IIS
5	Database Components (SQL, JDBC, Database servers)	Creating and querying databases	–	MySQL, phpMyAdmin
6	CAT 1 – Covering Weeks 1–5	See Breakdown below in Capstone Project	CAT 1 (15%)	MySQL Workbench, PHPStorm
7	Architecture & Design (N-tier, UI, Security Issues)	Designing secure multi-tier architecture	–	UML tools (StarUML, Lucidchart)
8	Object-Oriented Modelling (UML, WAC)	Creating UML diagrams for web apps	–	Enterprise Architect, Draw.io
9	Java Web Services (Servlet lifecycle, Session management, Cookies)	Implementing session tracking	–	Apache Tomcat, Eclipse
10	CAT 2 – Covering Weeks 6–9	See Breakdown below in Capstone Project	CAT 2 (15%)	NetBeans, IntelliJ IDEA
11	Dynamic HTML Generation & JDBC	Building dynamic pages with DB integration	–	JSP, JDBC drivers
12	ASP.NET Concepts (Object model, Control structures, Session management)	Developing ASP.NET forms	–	Visual Studio, SQL Server
13	Special Topics (COM, CORBA, RMI, LDAP, Search engines)	Implementing secure directory access (LDAP)	–	OpenLDAP, ElasticSearch
14	Website Testing, Publishing & Maintenance	Deploying and testing a full web application	Final Exam Prep	Selenium, GitHub Actions

Current Tools in Web Programming
Today’s web development landscape is dominated by modern frameworks and cloud-based tools that streamline development:
i.	Frontend Tools: React.js, Angular, Vue.js for dynamic interfaces; TailwindCSS and Bootstrap for styling.
ii.	Backend Tools: Node.js, Django, Laravel, Spring Boot for scalable server-side applications.
iii.	Databases: MySQL, PostgreSQL, MongoDB (NoSQL), Firebase for real-time apps.
iv.	Version Control & Collaboration: GitHub, GitLab, Bitbucket for source code management.
v.	Testing & Deployment: Selenium, Cypress for automated testing; Docker, Kubernetes, and CI/CD pipelines (GitHub Actions, Jenkins) for deployment.
vi.	Cloud Platforms: AWS, Azure, Google Cloud for hosting and scaling applications.
vii.	API Tools: Postman and Swagger for API design and testing.
The shift is toward full-stack development with frameworks like MEVN (MongoDB, Express, React, Node) and MEAN (MongoDB, Express, Angular, Node), plus DevOps integration for continuous delivery.
 
Real-World Project Mapping (Week 1–14)
Week	Topics / Activities	Real-World Project Application
1	Networking Fundamentals	Set up a local development environment (XAMPP/WAMP) and test HTTP requests with Postman.
2	Client-side Components (HTML/XML)	Build a personal portfolio homepage using semantic HTML and XML for structured data.
3	JavaScript & VBScript Basics	Create a form validation system for a contact page (e.g., email validation, password strength checker).
4	Server-side Components (PHP/ASP)	Develop a basic login system with PHP or ASP that connects to a database.
5	Database Components (SQL, JDBC)	Design a student records database and query it with SQL for CRUD operations.
6	CAT 1	Practical assessment: Build a mini blog site integrating client-side and server-side components.
7	Architecture & Design (N-tier, Security)	Draft a secure e-commerce architecture diagram with multi-tier layers (UI, business logic, database).
8	Object-Oriented Modelling (UML, WAC)	Create UML diagrams for a library management system web application.
9	Java Web Services (Servlets, Cookies)	Implement session management for a shopping cart in Java Servlets.
10	CAT 2	Practical assessment: Develop a user registration and login system with session tracking.
11	Dynamic HTML & JDBC	Build a news portal that dynamically fetches articles from a database using JSP/JDBC.
12	ASP.NET Concepts	Create an event booking system with ASP.NET forms and SQL Server integration.
13	Special Topics (COM, CORBA, LDAP, Search engines)	Implement secure directory access with LDAP and integrate a simple search engine for a knowledge base.
14	Website Testing, Publishing & Maintenance	Deploy a fully functional web application (e.g., e-commerce site) to a cloud platform and test with Selenium.

 
Capstone Project: Smart E-Commerce Web Application
Project Overview
Students will design and develop a multi-tier e-commerce platform that allows users to browse products, manage shopping carts, process orders, and administer content. The system will integrate frontend design, backend logic, database management, security, and deployment.

Key Deliverables
i.	Frontend: Responsive UI with HTML5, CSS3, JavaScript, Bootstrap/Tailwind.
ii.	Backend: PHP/ASP.NET with secure session management.
iii.	Database: MySQL/PostgreSQL with normalized schema.
iv.	Security: HTTPS, prepared statements, role-based access.
v.	Deployment: Cloud-hosted with CI/CD pipeline.
vi.	Testing: Automated with Selenium and PHP Unit.

Capstone Project relevance
i.	Integrates all weekly skills: Networking, client-side, server-side, databases, security, multimedia, testing, deployment.
ii.	Portfolio-ready: Students graduate with a fully functional e-commerce platform.
iii.	Industry relevance: Reflects real-world systems used by businesses globally.
iv.	Scalable: Can be extended with APIs, mobile apps, or microservices.


 
Capstone Project: Smart E-Commerce Web Application (Extra Features)
Core Features (Baseline)
i.	User registration, login, and role-based access (admin, customer).
ii.	Product catalog with categories, search, and filters.
iii.	Shopping cart and checkout system.
iv.	Order management and payment simulation.
v.	Secure database integration (MySQL/PostgreSQL).
vi.	Deployment to cloud (AWS/Azure/Google Cloud).
vii.	Automated testing and CI/CD pipeline.

Optional Advanced Features
🔹 AI-Powered Product Recommendations
i.	How: Use machine learning models (e.g., TensorFlow.js, Scikit-learn) to analyze user behavior and suggest products.
ii.	Example: “Customers who bought X also liked Y.”
iii.	Tools: Python (Flask API), TensorFlow.js, MongoDB for storing user activity.
🔹 Real-Time Chat Support
i.	How: Integrate WebSocket-based chat for customer support.
ii.	Example: Live chat with support agents or chatbot integration.
iii.	Tools: Socket.IO, Firebase Realtime Database, Dialogflow for chatbot AI.
🔹 Personalized Dashboards
i.	How: Provide customers with dashboards showing purchase history, recommendations, and loyalty points.
ii.	Tools: React.js or Angular for dynamic dashboards.
🔹 Mobile Responsiveness & PWA (Progressive Web App)
i.	How: Make the site installable on mobile devices with offline support.
ii.	Tools: Service Workers, Lighthouse for testing.
🔹 Secure Payment Gateway Integration
i.	How: Simulate or integrate with PayPal, Stripe, or M-Pesa APIs.
ii.	Tools: Stripe API, Safaricom Daraja API (for M-Pesa in Kenya).
🔹 Advanced Search & Filtering
i.	How: Implement full-text search and faceted filtering.
ii.	Tools: ElasticSearch, Algolia.
🔹 Cloud-Native Deployment
i.	How: Containerize the app with Docker and orchestrate with Kubernetes.
ii.	Tools: Docker, Kubernetes, GitHub Actions.
🔹 Analytics & Reporting
i.	How: Track user activity, sales trends, and generate reports.
ii.	Tools: Google Analytics, Power BI, Chart.js.

Extra Features for Innovation
i.	Voice Search Integration (using Web Speech API).
ii.	Augmented Reality (AR) Product Preview (e.g., try furniture in your room).
iii.	Gamification (loyalty points, badges for frequent buyers).
iv.	Multi-language Support (internationalization with i18n libraries).
v.	Accessibility Compliance (WCAG standards for inclusive design).

Why These Additions Matter
i.	They mirror real-world e-commerce platforms like Amazon, Jumia, or Shopify.
ii.	Students gain exposure to modern technologies (AI, cloud, real-time systems).
iii.	The project becomes portfolio-ready and demonstrates advanced problem-solving.
iv.	Employers value graduates who can integrate innovation into practical systems.

 
Capstone Project Integrated into CATs
CAT 1 (Week 6) – 15 Marks
Focus: Foundations and Core Setup 
Students demonstrate the ability to build the initial structure of the e-commerce application.
Tasks:
i.	Set up a local development environment (XAMPP/WAMP or IIS).
ii.	Create a basic product catalog using HTML, CSS, and JavaScript.
iii.	Implement form validation (e.g., login or registration form).
iv.	Connect to a database (MySQL/PostgreSQL) and perform CRUD operations (add, update, delete products).
v.	Deploy a simple login system with secure password storage.
Expected Output: 
A working prototype with a functional product catalog, database integration, and basic user authentication.

CAT 2 (Week 10) – 15 Marks
Focus: Advanced Features and Integration 
Students extend the prototype into a more dynamic, secure, and interactive system.
Tasks:
i.	Implement session management and cookies (shopping cart persistence).
ii.	Generate dynamic HTML content (e.g., product listings pulled from database).
iii.	Add role-based access control (admin vs. customer).
iv.	Integrate backend services (Java Servlets, PHP, or ASP.NET).
v.	Deploy the application to a cloud platform (AWS/Azure/Google Cloud).
vi.	Optional advanced features: AI-powered recommendations, real-time chat, secure payment gateway simulation.
Expected Output: 
A fully functional e-commerce application with dynamic content, secure sessions, and deployment-ready architecture.

Grading Breakdown (Total 30 Marks)
Section	Marks	Description
CAT 1 (Week 6)	15 Marks	Foundations: environment setup, product catalog, form validation, database CRUD, basic login system.
CAT 2 (Week 10)	15 Marks	Advanced integration: session management, dynamic content, role-based access, backend integration, deployment, optional advanced features.

Summary:
•	CAT 1 = Prototype : ensures students master the basics.
•	CAT 2 = Full Application :  ensures students can integrate advanced features and deploy.
•	Total:  CAT 1 + CAT 2 = Capstone Project, evaluated progressively for a total of 30 marks.

Note: 
1.	The Application Area May Vary but Key aspects to be observed.
2.	The Task is Individual oriented where learning can happen in peer sessions but each represents a task one fully understands
3.	Codes may be obtained from any sources and understanding fully demonstrated on weekly basis.
4.	The Lecturer will offer support and observe weekly programming. No final System will be accepted without lecturer monitoring the progress from design to implementation
