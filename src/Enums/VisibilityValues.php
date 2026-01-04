<?php

namespace Okorpheus\DocumentLibrary\Enums;

enum VisibilityValues: string
{
    case PUBLIC = 'public'; // Public files and directories are visible to the public
    case PRIVATE = 'private'; // Private files and directories are visible to the user and document library admins
    case RESTRICTED = 'restricted'; // Restricted files and directories are visible to logged in users

}
