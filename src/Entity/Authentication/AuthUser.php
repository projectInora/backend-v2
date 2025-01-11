<?php

namespace App\Entity\Authentication;

use App\Entity\Base\BaseFullRecord;
use App\Entity\Bid\BiddingStockBids;
use App\Entity\Image\Images;
use App\Entity\User\UserOTPRequest;
use App\Repository\Authentication\AuthUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AuthUserRepository::class)]
class AuthUser extends BaseFullRecord implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $username = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne]
    private ?AuthUserRole $authDefaultRole = null;

    #[ORM\ManyToOne]
    private ?Images $profileImage = null;

    #[ORM\Column(length: 12, nullable: true)]
    private ?string $nic = null;

    #[ORM\Column(length: 12, nullable: true)]
    private ?string $phoneNo = null;

    #[ORM\Column]
    private ?bool $isVerified = null;

    #[ORM\Column]
    private ?bool $activeLive = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastLoginedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $verifiedAt = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    #[ORM\ManyToOne]
    private ?UserOTPRequest $activeOTPRequest = null;

    /**
     * @var Collection<int, AuthUserAuthRoles>
     */
    #[ORM\OneToMany(targetEntity: AuthUserAuthRoles::class, mappedBy: 'authUser')]
    private Collection $authUserAuthRoles;

    /**
     * @var Collection<int, BiddingStockBids>
     */
    #[ORM\OneToMany(targetEntity: BiddingStockBids::class, mappedBy: 'bidBy')]
    private Collection $biddingStockBids;

    public function __construct()
    {
        $this->uuid = strtoupper(uniqid("US_"));
        parent::__construct();
        $this->authUserAuthRoles = new ArrayCollection();
        $this->biddingStockBids = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAuthDefaultRole(): ?AuthUserRole
    {
        return $this->authDefaultRole;
    }

    public function setAuthDefaultRole(?AuthUserRole $authDefaultRole): static
    {
        $this->authDefaultRole = $authDefaultRole;

        return $this;
    }

    public function getProfileImage(): ?Images
    {
        return $this->profileImage;
    }

    public function setProfileImage(?Images $profileImage): static
    {
        $this->profileImage = $profileImage;

        return $this;
    }

    public function getNic(): ?string
    {
        return $this->nic;
    }

    public function setNic(string $nic): static
    {
        $this->nic = $nic;

        return $this;
    }

    public function getPhoneNo(): ?string
    {
        return $this->phoneNo;
    }

    public function setPhoneNo(?string $phoneNo): static
    {
        $this->phoneNo = $phoneNo;

        return $this;
    }

    public function isVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function isActiveLive(): ?bool
    {
        return $this->activeLive;
    }

    public function setActiveLive(bool $activeLive): static
    {
        $this->activeLive = $activeLive;

        return $this;
    }

    public function getLastLoginedAt(): ?\DateTimeImmutable
    {
        return $this->lastLoginedAt;
    }

    public function setLastLoginedAt(\DateTimeImmutable $lastLoginedAt): static
    {
        $this->lastLoginedAt = $lastLoginedAt;

        return $this;
    }

    public function getVerifiedAt(): ?\DateTimeImmutable
    {
        return $this->verifiedAt;
    }

    public function setVerifiedAt(?\DateTimeImmutable $verifiedAt): static
    {
        $this->verifiedAt = $verifiedAt;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getActiveOTPRequest(): ?UserOTPRequest
    {
        return $this->activeOTPRequest;
    }

    public function setActiveOTPRequest(?UserOTPRequest $activeOTPRequest): static
    {
        $this->activeOTPRequest = $activeOTPRequest;

        return $this;
    }

    public function getRoles(): array
    {
        $ret = [];
        $role = $this->getAuthDefaultRole();
        if($role != null){
            $ret[] = $role->getCode();
        }

//        $authRoles = $this->getAuthUserAuthRoles();
//        foreach($authRoles as $authRole){
//            if($authRole->isAccessAllowed() && $authRole->isIsActive()){
//                $ret[] = $authRole->getAuthRole()->getCode();
//            }
//        }

        return $ret;
    }

    public function eraseCredentials()
    {

    }

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @return Collection<int, AuthUserAuthRoles>
     */
    public function getAuthUserAuthRoles(): Collection
    {
        return $this->authUserAuthRoles;
    }

    public function addAuthUserAuthRole(AuthUserAuthRoles $authUserAuthRole): static
    {
        if (!$this->authUserAuthRoles->contains($authUserAuthRole)) {
            $this->authUserAuthRoles->add($authUserAuthRole);
            $authUserAuthRole->setAuthUser($this);
        }

        return $this;
    }

    public function removeAuthUserAuthRole(AuthUserAuthRoles $authUserAuthRole): static
    {
        if ($this->authUserAuthRoles->removeElement($authUserAuthRole)) {
            // set the owning side to null (unless already changed)
            if ($authUserAuthRole->getAuthUser() === $this) {
                $authUserAuthRole->setAuthUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BiddingStockBids>
     */
    public function getBiddingStockBids(): Collection
    {
        return $this->biddingStockBids;
    }

    public function addBiddingStockBid(BiddingStockBids $biddingStockBid): static
    {
        if (!$this->biddingStockBids->contains($biddingStockBid)) {
            $this->biddingStockBids->add($biddingStockBid);
            $biddingStockBid->setBidBy($this);
        }

        return $this;
    }

    public function removeBiddingStockBid(BiddingStockBids $biddingStockBid): static
    {
        if ($this->biddingStockBids->removeElement($biddingStockBid)) {
            // set the owning side to null (unless already changed)
            if ($biddingStockBid->getBidBy() === $this) {
                $biddingStockBid->setBidBy(null);
            }
        }

        return $this;
    }
}
