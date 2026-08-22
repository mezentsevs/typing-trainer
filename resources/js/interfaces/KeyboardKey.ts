import { SpecialPosition, Zone } from '@/enums/KeyboardEnums';

export default interface KeyboardKey {
    altGr?: string;
    altGrPosition?: SpecialPosition | null;
    display: string;
    special?: string;
    specialPosition?: SpecialPosition | null;
    value: string;
    width?: number;
    zone?: Zone | null;
}
