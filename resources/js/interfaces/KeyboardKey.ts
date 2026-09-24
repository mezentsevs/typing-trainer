import { SpecialPosition, Zone } from '@/enums/KeyboardEnums';

export default interface KeyboardKey {
    value: string;
    display: string;
    special?: string;
    specialPosition?: SpecialPosition | null;
    altGr?: string;
    altGrPosition?: SpecialPosition | null;
    altGrShift?: string;
    capsLock?: string;
    width?: number;
    zone?: Zone | null;
}
