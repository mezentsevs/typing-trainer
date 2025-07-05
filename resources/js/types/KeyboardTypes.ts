import KeyboardKey from '@/interfaces/KeyboardKey';
import { SpecialPosition, Zone } from '@/enums/KeyboardEnums';

export type KeyboardLayout = KeyboardKey[][];
export type KeyboardSpecialPosition = SpecialPosition | null;
export type KeyboardZone = Zone | null;
