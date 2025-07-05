import { KeyboardSpecialPosition, KeyboardZone } from '@/types/KeyboardTypes';

export default interface KeyboardKey {
    value: string;
    display: string;
    special?: string;
    specialPosition?: KeyboardSpecialPosition;
    width?: number;
    zone?: KeyboardZone;
}
