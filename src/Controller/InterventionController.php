<?php
namespace App\Controller;

use App\Entity\Intervention;
use App\Repository\InterventionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/interventions")]
class InterventionController extends AbstractController
{
    #[Route("/", name: "intervention_index", methods: ["GET"])]
    public function index(
        Request $request,
        InterventionRepository $repo,
    ): Response {
        $technician = $request->query->get("technician");
        $status = $request->query->get("status");

        $interventions = $repo->findByFilters($technician, $status);
        $technicians = $repo->findDistinctTechnicians();

        return $this->render("intervention/index.html.twig", [
            "interventions" => $interventions,
            "technicians" => $technicians,
            "currentTechnician" => $technician,
            "currentStatus" => $status,
        ]);
    }

    #[Route("/new", name: "intervention_new", methods: ["GET", "POST"])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod("POST")) {
            $d = $request->request;
            // server-side validation minimal
            if (!filter_var($d->get("email"), FILTER_VALIDATE_EMAIL)) {
                $this->addFlash("danger", "Email invalide");
                return $this->redirectToRoute("intervention_new");
            }
            $scheduledAt = \DateTime::createFromFormat(
                "Y-m-d\TH:i",
                $d->get("scheduledAt"),
            );
            if (!$scheduledAt) {
                $this->addFlash("danger", "Date/heure invalide");
                return $this->redirectToRoute("intervention_new");
            }

            $intv = new Intervention();
            $intv->setReference(uniqid("INT-"));
            $intv->setFirstName($d->get("firstName"));
            $intv->setLastName($d->get("lastName"));
            $intv->setAddress($d->get("address"));
            $intv->setPhone($d->get("phone"));
            $intv->setEmail($d->get("email"));
            $intv->setDescription($d->get("description"));
            $intv->setScheduledAt($scheduledAt);
            $intv->setTechnician($d->get("technician"));
            $intv->setStatus("en cours");

            $em->persist($intv);
            $em->flush();

            $this->addFlash("success", "Intervention créée.");
            return $this->redirectToRoute("intervention_index");
        }

        // exemple de techniciens (datalist)
        $techs = ["Ali", "Baba", "Chloé", "Diane"];
        return $this->render("intervention/new.html.twig", ["techs" => $techs]);
    }

    #[
        Route(
            "/{id}/status",
            name: "intervention_change_status",
            methods: ["POST"],
        ),
    ]
    public function changeStatus(
        Intervention $intervention,
        Request $request,
        EntityManagerInterface $em,
    ): Response {
        $status = $request->request->get("status");
        $allowed = ["en cours", "validée", "terminée", "annulée"];
        if (!in_array($status, $allowed)) {
            $this->addFlash("danger", "État invalide.");
        } else {
            $intervention->setStatus($status);
            $em->flush();
            $this->addFlash("success", "État mis à jour.");
        }
        return $this->redirectToRoute("intervention_index");
    }

    #[Route("/{id}", name: "intervention_show", methods: ["GET"])]
    public function show(Intervention $intervention): Response
    {
        return $this->render("intervention/show.html.twig", [
            "intervention" => $intervention,
        ]);
    }
}
