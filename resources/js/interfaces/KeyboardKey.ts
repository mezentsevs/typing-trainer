import { SpecialPosition, Zone } from '@/enums/KeyboardEnums';

export default interface KeyboardKey {
    value: string;
    display: string;
    special?: string;
    specialPosition?: SpecialPosition | null;
    width?: number;
    zone?: Zone | null;
}
