<?php

namespace App\Controller;

use App\Entity\Clinic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Doctor;
use App\Entity\Service;
use App\Entity\TimeSlot;
use Symfony\Component\HttpFoundation\Response;


class ApiController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * "/upload", name="upload", methods={"POST"}
     */
    public function upload(Request $request): JsonResponse
    {
        // Получаем данные из запроса.
        $data = json_decode($request->getContent(), true);

        $successCount = 0;
        $doctorsData = [];

        // Обходим всех докторов в массиве и сохраняем их в базу данных.
        if (isset($data['doctors'])) {
            foreach ($data['doctors'] as $doctorData) {
                // Создаем новый объект Doctor.
                $doctor = new Doctor();

                // Заполняем объект свойствами из запроса.
                if (isset($doctorData['name'])) {
                    $doctor->setName($doctorData['name']);
                }
                if (isset($doctorData['surname'])) {
                    $doctor->setSurname($doctorData['surname']);
                }
                if (isset($doctorData['lastname'])) {
                    $doctor->setLastname($doctorData['lastname']);
                }
                if (isset($doctorData['specialization'])) {
                    $doctor->setSpecialization($doctorData['specialization']);
                }
                if (isset($doctorData['description'])) {
                    $doctor->setDescription($doctorData['description']);
                }
                if (isset($doctorData['email'])) {
                    $doctor->setEmail($doctorData['email']);
                }
                if (isset($doctorData['password'])) {
                    $doctor->setPassword($doctorData['password']);
                }
                if (isset($doctorData['photo'])) {
                    $doctor->setPhoto($doctorData['photo']);
                }
                if (isset($doctorData['city'])) {
                    $doctor->setCity($doctorData['city']);
                }

                $clinic = null;

                // Привязываем доктора к клинике, если есть информация о клинике.
                if (isset($doctorData['clinic_id']) && is_numeric($doctorData['clinic_id'])) {
                    $clinic = $this->entityManager->getRepository(Clinic::class)->find($doctorData['clinic_id']);
                    if ($clinic) {
                        $clinic->addDoctor($doctor);
                        $this->entityManager->persist($clinic);
                    }
                }

                // Обходим все услуги врача и сохраняем их в базу данных.
                if (isset($doctorData['services'])) {
                    foreach ($doctorData['services'] as $serviceData) {
                        // Создаем новый объект Service.
                        $service = new Service();

                        // Заполняем объект свойствами из запроса.
                        if (isset($serviceData['name'])) {
                            $service->setName($serviceData['name']);
                        }
                        if (isset($serviceData['price'])) {
                            $service->setPrice($serviceData['price']);
                        }

                        // Привязываем услугу к доктору.
                        $service->setDoctor($doctor);

                        // Сохраняем объект в базу данных.
                        $this->entityManager->persist($service);
                    }
                }

                // Сохраняем объект в базу данных.
                $this->entityManager->persist($doctor);

                try {
                    // Сохраняем изменения.
                    $this->entityManager->flush();

                    // Увеличиваем счетчик успешно сохраненных докторов.
                    $successCount++;

                    // Получаем ID добавленного врача и сохраняем его данные в массиве.
                    $doctorId = $doctor->getId();
                    $doctorsData[] = [
                        'id' => $doctorId,
                        'name' => $doctor->getName(),
                        'surname' => $doctor->getSurname(),
                        'lastname' => $doctor->getLastname(),
                        'specialization' => $doctor->getSpecialization(),
                        'description' => $doctor->getDescription(),
                        'email' => $doctor->getEmail(),
                        'password' => $doctor->getPassword(),
                        'photo' => $doctor->getPhoto(),
                        'city' => $doctor->getCity(),
                        'clinic_id' => $clinic ? $clinic->getId() : null,
                    ];

                } catch (\Exception $e) {
                    // Откатываем все изменения в базе данных в случае ошибки.
                    $this->entityManager->rollback();
                    throw $e;
                }
            }
        }

        // Возвращаем JSON с сообщением об успехе, количеством сохраненных докторов и данными добавленных врачей.
        return new JsonResponse([
            'success' => true,
            'count' => $successCount,
            'doctors' => $doctorsData,
        ]);
    }

    /**
     * "/uploadTimeSlots", name="upload_time_slots", methods={"POST"}
     */
    public function uploadTimeSlots(Request $request, EntityManagerInterface $entityManager): Response
    {
        $jsonData = json_decode($request->getContent(), true);
        $createdTimeSlots = [];

        // Create new time slots from JSON data
        foreach ($jsonData['timeSlots'] as $slotData) {
            $timeSlot = new TimeSlot();
            $timeSlot->setStart(new \DateTime($slotData['start']));
            $timeSlot->setTimeEnd(new \DateTime($slotData['timeEnd']));
            $timeSlot->setDate(new \DateTime($slotData['date']));
            $timeSlot->setBooked($slotData['booked']);
            $doctor = $entityManager->getRepository(Doctor::class)->find($slotData['doctor_id']);
            $timeSlot->setDoctor($doctor);
            $clinic = $entityManager->getRepository(Clinic::class)->find($slotData['clinic_id']);
            $timeSlot->setClinic($clinic);
            $entityManager->persist($timeSlot);

            $createdTimeSlots[] = [
                'id' => $timeSlot->getId(),
                'start' => $timeSlot->getStart()->format('Y-m-d H:i:s'),
                'time_end' => $timeSlot->getTimeEnd()->format('Y-m-d H:i:s'),
                'date' => $timeSlot->getDate()->format('Y-m-d'),
                'booked' => $timeSlot->isBooked(),
                'doctor_id' => $timeSlot->getDoctor()->getId(),
                'clinic_id' => $timeSlot->getClinic()->getId(),
            ];
        }
        $entityManager->flush();

        // Return a success response with created time slots data
        return new JsonResponse(['time_slots' => $createdTimeSlots], Response::HTTP_CREATED);
    }
}