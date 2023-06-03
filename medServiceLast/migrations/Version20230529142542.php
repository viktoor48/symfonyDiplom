<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529142542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE clinic_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE doctor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE review_clinic_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE review_doctor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE service_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE time_slot_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, date DATE NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, gender VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE clinic (id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, number VARCHAR(255) NOT NULL, specialization VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE clinic_doctor (clinic_id INT NOT NULL, doctor_id INT NOT NULL, PRIMARY KEY(clinic_id, doctor_id))');
        $this->addSql('CREATE INDEX IDX_A09916D5CC22AD4 ON clinic_doctor (clinic_id)');
        $this->addSql('CREATE INDEX IDX_A09916D587F4FB17 ON clinic_doctor (doctor_id)');
        $this->addSql('CREATE TABLE doctor (id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, specialization VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE review_clinic (id INT NOT NULL, clinic_id INT DEFAULT NULL, client_id INT DEFAULT NULL, liked VARCHAR(255) DEFAULT NULL, not_liked VARCHAR(255) DEFAULT NULL, attitude_med_staff INT NOT NULL, waiting_time INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8DF5BF74CC22AD4 ON review_clinic (clinic_id)');
        $this->addSql('CREATE INDEX IDX_8DF5BF7419EB6921 ON review_clinic (client_id)');
        $this->addSql('CREATE TABLE review_doctor (id INT NOT NULL, doctor_id INT DEFAULT NULL, client_id INT DEFAULT NULL, liked INT NOT NULL, not_liked INT NOT NULL, date DATE NOT NULL, advise INT NOT NULL, treatment_effectivness INT NOT NULL, attitude_to_patient VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_95B6B4AA87F4FB17 ON review_doctor (doctor_id)');
        $this->addSql('CREATE INDEX IDX_95B6B4AA19EB6921 ON review_doctor (client_id)');
        $this->addSql('CREATE TABLE service (id INT NOT NULL, doctor_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E19D9AD287F4FB17 ON service (doctor_id)');
        $this->addSql('CREATE TABLE time_slot (id INT NOT NULL, client_id INT DEFAULT NULL, doctor_id INT NOT NULL, service_id INT DEFAULT NULL, clinic_id INT DEFAULT NULL, start TIME(0) WITHOUT TIME ZONE NOT NULL, time_end TIME(0) WITHOUT TIME ZONE NOT NULL, booked BOOLEAN NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1B3294A19EB6921 ON time_slot (client_id)');
        $this->addSql('CREATE INDEX IDX_1B3294A87F4FB17 ON time_slot (doctor_id)');
        $this->addSql('CREATE INDEX IDX_1B3294AED5CA9E6 ON time_slot (service_id)');
        $this->addSql('CREATE INDEX IDX_1B3294ACC22AD4 ON time_slot (clinic_id)');
        $this->addSql('ALTER TABLE clinic_doctor ADD CONSTRAINT FK_A09916D5CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE clinic_doctor ADD CONSTRAINT FK_A09916D587F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review_clinic ADD CONSTRAINT FK_8DF5BF74CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review_clinic ADD CONSTRAINT FK_8DF5BF7419EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review_doctor ADD CONSTRAINT FK_95B6B4AA87F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review_doctor ADD CONSTRAINT FK_95B6B4AA19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD287F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE time_slot ADD CONSTRAINT FK_1B3294A19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE time_slot ADD CONSTRAINT FK_1B3294A87F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE time_slot ADD CONSTRAINT FK_1B3294AED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE time_slot ADD CONSTRAINT FK_1B3294ACC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE clinic_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE doctor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE review_clinic_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE review_doctor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE service_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE time_slot_id_seq CASCADE');
        $this->addSql('ALTER TABLE clinic_doctor DROP CONSTRAINT FK_A09916D5CC22AD4');
        $this->addSql('ALTER TABLE clinic_doctor DROP CONSTRAINT FK_A09916D587F4FB17');
        $this->addSql('ALTER TABLE review_clinic DROP CONSTRAINT FK_8DF5BF74CC22AD4');
        $this->addSql('ALTER TABLE review_clinic DROP CONSTRAINT FK_8DF5BF7419EB6921');
        $this->addSql('ALTER TABLE review_doctor DROP CONSTRAINT FK_95B6B4AA87F4FB17');
        $this->addSql('ALTER TABLE review_doctor DROP CONSTRAINT FK_95B6B4AA19EB6921');
        $this->addSql('ALTER TABLE service DROP CONSTRAINT FK_E19D9AD287F4FB17');
        $this->addSql('ALTER TABLE time_slot DROP CONSTRAINT FK_1B3294A19EB6921');
        $this->addSql('ALTER TABLE time_slot DROP CONSTRAINT FK_1B3294A87F4FB17');
        $this->addSql('ALTER TABLE time_slot DROP CONSTRAINT FK_1B3294AED5CA9E6');
        $this->addSql('ALTER TABLE time_slot DROP CONSTRAINT FK_1B3294ACC22AD4');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE clinic');
        $this->addSql('DROP TABLE clinic_doctor');
        $this->addSql('DROP TABLE doctor');
        $this->addSql('DROP TABLE review_clinic');
        $this->addSql('DROP TABLE review_doctor');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE time_slot');
    }
}
